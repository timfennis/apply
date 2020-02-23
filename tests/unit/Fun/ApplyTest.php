<?php

declare(strict_types=1);

namespace Test\Apply\Fun;

use function Apply\Fun\apply;
use Apply\Functions;
use Codeception\Test\Unit;

class ApplyTest extends Unit
{
    public function testWithAdd()
    {
        $add = static function ($a, $b) {
            return $a + $b;
        };

        $addOne = apply($add, 1);

        $this->assertSame(5, $addOne(4));
        $this->assertSame(10, apply($add)(5, 5));
    }

    public function testWithSingleArgument()
    {
        $this->assertSame(10, apply(Functions::identity, 10)());
    }

    public function testWithNoArguments()
    {
        $this->assertSame(10, apply(\Apply\Fun\constant(10))());
    }
}
