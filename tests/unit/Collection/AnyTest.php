<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\any;
use Apply\Functions;
use Codeception\Test\Unit;

class AnyTest extends Unit
{
    public function testEverythingTrueIsTrue()
    {
        $this->assertTrue(any([true, true, true, true], Functions::identity));
    }

    public function testJustOneTrueIsTrue()
    {
        $this->assertTrue(any([true, false, false, false], Functions::identity));
    }

    public function testEverythingFalseIsFalse()
    {
        $this->assertFalse(any([false, false, false, false], Functions::identity));
    }
}
