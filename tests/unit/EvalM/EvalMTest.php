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

        $e = new EvalM(static function () use (&$modified) {
            $modified = true;
            return 5;
        });

        $e = $e->map(static function (int $a) {
            return $a + 5;
        });

        $this->assertFalse($modified);

        $this->assertSame(10, $e());
    }

    public function testFlatMap(): void
    {
        $modified = false;

        $e = new EvalM(static function () use (&$modified) {
            $modified = true;
            return 5;
        });

        $e = $e->flatMap(static function (int $a) {
            return new EvalM(static function () use ($a) {
                return $a + 5;
            });
        });

        $this->assertFalse($modified);

        $this->assertSame(10, $e());
    }
}
