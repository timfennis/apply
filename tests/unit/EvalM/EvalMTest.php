<?php

declare(strict_types=1);

namespace Test\Apply\EvalM;

use Apply\EvalM\EvalM;
use Codeception\Test\Unit;

class EvalMTest extends Unit
{
    public function testLazyBinding()
    {
        $aCalled = false;
        $functionA = function () use (&$aCalled) {
            $aCalled = true;

            return 5;
        };

        $bCalled = false;
        $functionB = function () use (&$bCalled) {
            $bCalled = true;

            return 6;
        };

        $result = EvalM::lazyBinding(static function () use ($functionA, $functionB) {
            $a = yield EvalM::later($functionA);
            $b = yield EvalM::later($functionB);

            return $a + $b;
        });

        $this->assertFalse($aCalled);
        $this->assertFalse($bCalled);

        $this->assertSame(11, $result->value);

        $this->assertTrue($aCalled);
        $this->assertTrue($bCalled);
    }

    public function testNonLazyBinding()
    {
        $aCalled = false;
        $functionA = function () use (&$aCalled) {
            $aCalled = true;

            return 5;
        };

        $bCalled = false;
        $functionB = function () use (&$bCalled) {
            $bCalled = true;

            return 6;
        };

        $result = EvalM::binding(static function () use ($functionA, $functionB) {
            $a = yield EvalM::later($functionA);
            $b = yield EvalM::later($functionB);

            return $a + $b;
        });

        $this->assertTrue($aCalled);
        $this->assertTrue($bCalled);

        $this->assertSame(11, $result->value);
    }

    // tests
    public function testMap(): void
    {
        $modified = false;

        $e = EvalM::later(static function () use (&$modified) {
            $modified = true;

            return 5;
        });

        $e = $e->map(static function (int $a) {
            return $a + 5;
        });

        $this->assertFalse($modified);

        $this->assertSame(10, $e->value);
    }

    public function testFlatMap(): void
    {
        $modified = false;

        $e = EvalM::later(static function () use (&$modified) {
            $modified = true;

            return 5;
        });

        $e = $e->flatMap(static function (int $a) {
            return EvalM::later(static function () use ($a) {
                return $a + 5;
            });
        });

        $this->assertFalse($modified);

        $this->assertSame(10, $e->value);
    }

    public function testThatItDoesNotBlowUpTheCallStack(): void
    {
        $e = EvalM::now(0);

        for ($i = 0; $i < 100; ++$i) {
            $e = $e->map(static function ($a) {
                return $a + 1;
            });
        }

        // Okay so PHP doens't really have a stack overflow error but xdebug does, and as long as xdebug is enabled it will throw errors
        $this->assertSame(100, $e->value);
    }
}
