<?php

declare(strict_types=1);

namespace Test\Apply\Attempt;

use Apply\Attempt\Attempt;
use function Apply\constant;
use Apply\Either\Left;
use Apply\Functions;
use Codeception\Test\Unit;
use Exception;
use RuntimeException;
use Throwable;

class AttemptTest extends Unit
{
    public function testWithRuntimeException(): void
    {
        $try = Attempt::of(static function () {
            throw new RuntimeException('Hello this is the runtime exception');
        });

        $this->assertTrue($try->isFailure());
        $this->assertFalse($try->isSuccess());

        /** @var Exception $exception */
        $exception = null;
        $value = null;

        $try->fold(static function ($v) use (&$exception) {
            $exception = $v;
        }, static function ($v) use (&$value) {
            $value = $v;
        });

        $this->assertNull($value);

        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertSame('Hello this is the runtime exception', $exception->getMessage());
    }

    public function testMappingOverSuccess(): void
    {
        $try = Attempt::of(static function () {
            return 5;
        });
        $try = $try->map(static function ($n) {
            return $n + 1;
        });

        $this->assertSame(6, $try->fold(constant(null), Functions::identity));

        $try = $try->flatMap(static fn ($n) => Attempt::of(static fn () => $n + 1));

        $this->assertSame(7, $try->fold(constant(null), Functions::identity));

        // Test that exists works like expected
        $this->assertTrue($try->exists(static fn ($a) => 7 === $a));

        $this->assertSame(7, $try->getOrDefault(1337));
    }

    public function testIsStatusFunctions()
    {
        $s = Attempt::just(1);
        $f = Attempt::raiseError(new RuntimeException('Oopsiewoopsie'));

        $this->assertTrue($s->isSuccess());
        $this->assertFalse($s->isFailure());

        $this->assertFalse($f->isSuccess());
        $this->assertTrue($f->isFailure());
    }

    public function testJustConstructor(): void
    {
        $try = Attempt::just(5);
        $this->assertSame(5, $try->fold(constant(null), Functions::identity));
    }

    public function testRaiseErrorConstructor(): void
    {
        $try = Attempt::raiseError(new RuntimeException('This is an error'));
        $e = $try->fold(Functions::identity, constant(null));

        $this->assertInstanceOf(RuntimeException::class, $e);
        $this->assertSame('This is an error', $e->getMessage());
        $this->assertFalse($try->exists(constant(true)));
        $this->assertSame(1337, $try->getOrElse(static fn () => 1337));

        $this->assertSame(1337, $try->getOrDefault(1337));
    }

    public function testBindingOverFailure(): void
    {
        $try = Attempt::raiseError(new RuntimeException('We\'re screwed'));
        $result = $try->flatMap(static fn () => Attempt::just(1));
        $this->assertSame($try, $result);
    }

    /**
     * @dataProvider monadBindingProvider
     *
     * @param $expectedResult
     */
    public function testMonadBinding(Attempt $a, Attempt $b, $expectedResult): void
    {
        $result = Attempt::binding(static function () use ($a, $b) {
            $x = yield $a;
            $y = yield $b;

            return $x + $y;
        });

        if ($result->isFailure()) {
            $this->assertTrue($result->isFailure());

            $result->fold(
                fn (Throwable $exception) => $this->assertSame($expectedResult, $exception->getMessage()),
                fn ($_) => $this->fail('This callable should not be called')
            );
        }

        if ($result->isSuccess()) {
            $this->assertTrue($result->isSuccess());

            $this->assertSame($expectedResult, $result->getOrElse(fn () => $this->fail('This callable should not be called')));
        }
    }

    public function monadBindingProvider()
    {
        return [
            [Attempt::just(1), Attempt::just(2), 3],
            [Attempt::raiseError(new RuntimeException('error')), Attempt::just(2), 'error'],
            [Attempt::just(2), Attempt::raiseError(new RuntimeException('error')), 'error'],
            [Attempt::raiseError(new RuntimeException('error1')), Attempt::raiseError(new RuntimeException('error2')), 'error1'],
        ];
    }

    public function testToEither()
    {
        $a = Attempt::of(fn () => 1);
        $this->assertTrue($a->toEither()->isRight());

        $b = Attempt::raiseError(new RuntimeException('Kapot'));
        $this->assertTrue($b->toEither()->isLeft());

        $mustBeCalled = false;
        $either = $b->toEither(function (RuntimeException $exception) use (&$mustBeCalled) {
            $mustBeCalled = true;

            return 'It went wrong';
        });

        $this->assertTrue($mustBeCalled, 'Failed asserting that a lambda was called');
        $this->assertInstanceOf(Left::class, $either);

        $valueInEither = null;
        $either->fold(
            function ($value) use (&$valueInEither) {
                $valueInEither = $value;
            },
            fn ($a) => $a
        );

        $this->assertSame('It went wrong', $valueInEither);
    }
}
