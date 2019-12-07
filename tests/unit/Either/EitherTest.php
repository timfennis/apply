<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Either;

use Apply\Either\Either;
use Apply\Either\Left;
use Apply\Either\Right;
use Apply\Functions;
use Apply\Option\None;
use Apply\Option\Some;
use Codeception\Test\Unit;

class EitherTest extends Unit
{
    public function testLeft()
    {
        $left = new Left(1);
        $this->assertTrue($left->isLeft());
        $this->assertFalse($left->isRight());
    }

    public function testRight()
    {
        $right = new Right(5);
        $this->assertFalse($right->isLeft());
        $this->assertTrue($right->isRight());
    }

    public function testMap()
    {
        $right = (new Right(5))->map(static function ($a) {
            return $a + 5;
        });
        $this->assertSame(10, $right->orNull());

        $left = (new Left(5))->map(static function ($a) {
            return $a + 5;
        });
        $this->assertNull($left->orNull());
    }

    public function testBimap()
    {
        $value = (new Left(5))
            ->bimap(static function ($a) {
                return $a + 10;
            }, static function ($a) {
                return -100;
            })
            ->getOrHandle(Functions::identity);

        $this->assertSame(15, $value);
    }

    public function testSwap()
    {
        $left = new Left(10);
        $this->assertInstanceOf(Right::class, $left->swap());
        $this->assertSame(10, $left->swap()->orNull());

        $right = new Right(10);
        $this->assertInstanceOf(Left::class, $right->swap());
        $this->assertNull($right->swap()->orNull());
    }

    /**
     * @dataProvider flatMapDataProvider
     *
     * @param mixed $expectedResult
     */
    public function testFlatMap(Either $either, Either $otherEither, $expectedResult)
    {
        $either = $either->flatMap(static function () use ($otherEither) {
            return $otherEither;
        });

        $this->assertSame($expectedResult, $either->orNull());
    }

    public function testFold()
    {
        $left = new Left(10);
        $this->assertSame(5, $left->fold(static function ($a) {
            return $a - 5;
        }, static function ($a) {
            return $a + 5;
        }));

        $right = new Right(10);
        $this->assertSame(15, $right->fold(static function ($a) {
            return $a - 5;
        }, static function ($a) {
            return $a + 5;
        }));
    }

    public function testExist(): void
    {
        $isTen = function ($a) {
            return 10 === $a;
        };

        $left = new Left(10);
        $this->assertFalse($left->exists($isTen));

        $right = new Right(10);
        $this->assertTrue($right->exists($isTen));
    }

    public function testToOption(): void
    {
        $this->assertInstanceOf(None::class, (new Left(1))->toOption());
        $this->assertInstanceOf(Some::class, (new Right(1))->toOption());
        $this->assertSame(1, (new Right(1))->toOption()->get());
    }

    public function testGetOrElse(): void
    {
        $leftCalled = false;
        $rightCalled = false;

        $left = new Left(10);
        $leftResponse = $left->getOrElse(static function () use (&$leftCalled) {
            $leftCalled = true;

            return 123;
        });

        $right = new Right(10);
        $rightResponse = $right->getOrElse(static function () use (&$rightCalled) {
            $rightCalled = true;
        });

        $this->assertTrue($leftCalled);
        $this->assertFalse($rightCalled);
        $this->assertSame(123, $leftResponse);
        $this->assertSame(10, $rightResponse);
    }

    public function flatMapDataProvider(): array
    {
        return [
            [new Left(5), new Left(1), null],
            [new Right(5), new Left(2), null],
            [new Left(3), new Right(7), null],
            [new Right(5), new Right(6), 6],
        ];
    }

    /**
     * @dataProvider eitherBindingDataProvider
     */
    public function testEitherBinding(Either $a, Either $b, Either $expectedResult)
    {
        $result = Either::binding(static function () use ($a, $b) {
            $x = yield $a;
            $y = yield $b;

            return $x + $y;
        });

        if ($expectedResult->isLeft()) {
            $this->assertTrue($result->isLeft());
        } else {
            $this->assertTrue($result->isRight());
        }

        $this->assertEquals($expectedResult, $result);
    }

    public function eitherBindingDataProvider()
    {
        return [
            [new Left(1), new Left(1), new Left(1)],
            [new Left(1), new Right(1), new Left(1)],
            [new Right(1), new Left(1), new Left(1)],
            [new Right(1), new Right(1), new Right(2)],
        ];
    }

    public function testLeftIfNull()
    {
        // Test with non-null right
        $e = new Right(1);
        $e = $e->leftIfNull(fn () => 1);
        $this->assertInstanceOf(Right::class, $e);

        // Test with left
        $e = new Left(1);
        $e = $e->leftIfNull(fn () => 1);
        $this->assertInstanceOf(Left::class, $e);

        // Test with null
        $e = new Right(null);
        $e = $e->leftIfNull(fn () => new \RuntimeException('NULL'));
        $this->assertInstanceOf(Left::class, $e);
        $wasCalled = false;
        $e->handleErrorWith(function ($value) use (&$wasCalled) {
            $wasCalled = true;
            $this->assertInstanceOf(\RuntimeException::class, $value);

            return new Right(1);
        });

        $this->assertTrue($wasCalled, 'Failed asserting that the callable was called');
    }

    public function testFilterOrElseWithTruePredicate()
    {
        $e = new Right(10);
        $e = $e->filterOrElse(fn ($num) => $num > 5, fn () => 'too low');

        $value = $e->getOrElse(fn () => 'no comprende');
        $this->assertSame(10, $value);
    }

    public function testFilterOrElseWithFalsePredicate()
    {
        $e = new Right(10);
        $e = $e->filterOrElse(fn ($num) => $num > 20, fn () => 'too low');

        $value = $e->getOrElse(fn () => 'no comprende');
        $this->assertSame('no comprende', $value);
    }

    public function testFilterOrElseWithLeft()
    {
        $e = new Left(100);
        $e = $e->filterOrElse(fn ($i) => $this->fail('this code should not be executed'), fn () => $this->fail('this code should not be executed'));
        $this->assertSame(100, $e->fold(fn ($x) => $x, fn () => $this->fail('this code should not be executed')));
    }

    public function testFilterOrOther()
    {
        $e = new Right(10);
        $e = $e->filterOrOther(
            fn($num) => $num < 5,
            fn() => new Left('OOPS')
        );

        $e->fold(
            fn($msg) => $this->assertSame('OOPS', $msg),
            fn($a) => $this->fail('This function must not be called'),
        );
    }
}
