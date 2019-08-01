<?php

namespace Test\Apply\EvalM;

use Codeception\Test\Unit;
use FunctionalTester;
use Apply\EvalM\EvalM;

class EvalMTest extends Unit
{
    /**
     * @var FunctionalTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
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

    public function testThatItDoesNotBlowUpTheCallStack()
    {
        $e = EvalM::now(0);

        for ($i = 0; $i < 1000; $i++) {
            $e = $e->map(static function ($a) {
                return $a + 1;
            });
        }

        // Okay so PHP doens't really have a stack overflow error but xdebug does, and as long as xdebug is enabled it will throw errors
        $this->assertSame(200, $e->value);
    }
}
