<?php


namespace Test\Apply\TryM;

use Apply\Functions;
use Apply\TryM\TryM;
use Codeception\Test\Unit;
use Exception;
use RuntimeException;
use Throwable;
use function \Apply\constant;
use function foo\func;

class TryMTest extends Unit
{
    public function testWithRuntimeException(): void
    {
        $try = TryM::of(static function () {
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
        $try = TryM::of(static function () {
            return 5;
        });
        $try = $try->map(static function ($n) {
            return $n + 1;
        });

        $this->assertSame(6, $try->fold(constant(null), Functions::identity));

        $try = $try->flatMap(static function ($n) {
            return TryM::of(static function () use ($n) {
                return $n + 1;
            });
        });


        $this->assertSame(7, $try->fold(constant(null), Functions::identity));

        // Test that exists works like expected
        $this->assertTrue($try->exists(static function ($a) {
            return $a === 7;
        }));

        $this->assertSame(7, $try->getOrDefault(1337));
    }

    public function testIsStatusFunctions()
    {
        $s = TryM::just(1);
        $f = Trym::raiseError(new RuntimeException('Oopsiewoopsie'));

        $this->assertTrue($s->isSuccess());
        $this->assertFalse($s->isFailure());

        $this->assertFalse($f->isSuccess());
        $this->assertTrue($f->isFailure());
    }

    public function testJustConstructor(): void
    {
        $try = TryM::just(5);
        $this->assertSame(5, $try->fold(constant(null), Functions::identity));
    }

    public function testRaiseErrorConstructor(): void
    {
        $try = TryM::raiseError(new RuntimeException('This is an error'));
        $e = $try->fold(Functions::identity, constant(null));

        $this->assertInstanceOf(RuntimeException::class, $e);
        $this->assertSame('This is an error', $e->getMessage());
        $this->assertFalse($try->exists(constant(true)));
        $this->assertSame(1337, $try->getOrElse(static function () {
            return 1337;
        }));

        $this->assertSame(1337, $try->getOrDefault(1337));
    }

    public function testBindingOverFailure(): void
    {
        $try = TryM::raiseError(new RuntimeException('We\'re screwed'));
        $result = $try->flatMap(static function () {
            return TryM::just(1);
        });
        $this->assertSame($try, $result);
    }

    /**
     * @dataProvider monadBindingProvider
     *
     * @param TryM $a
     * @param TryM $b
     * @param $expectedResult
     */
    public function testMonadBinding(TryM $a, TryM $b, $expectedResult): void
    {
        $result = TryM::binding(static function () use ($a, $b) {
            $x = yield $a;
            $y = yield $b;

            return $x + $y;
        });

        if ($result->isFailure()) {
            $this->assertTrue($result->isFailure());

            $result->fold(function (Throwable $exception) use ($expectedResult) {
                $this->assertSame($expectedResult, $exception->getMessage());
            }, function ($_) {
                $this->fail('This callable should not be called');
            });
        }

        if ($result->isSuccess()) {
            $this->assertTrue($result->isSuccess());

            $this->assertSame($expectedResult, $result->getOrElse(function () {
                $this->fail('This callable should not be called');
            }));
        }
    }

    public function monadBindingProvider()
    {
        return [
            [TryM::just(1), TryM::just(2), 3],
            [TryM::raiseError(new RuntimeException('error')), TryM::just(2), 'error'],
            [TryM::just(2), TryM::raiseError(new RuntimeException('error')), 'error'],
            [TryM::raiseError(new RuntimeException('error1')), TryM::raiseError(new RuntimeException('error2')), 'error1'],
        ];
    }
}
