<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\all;
use Apply\Functions;
use Codeception\Test\Unit;

class AllTest extends Unit
{
    public function testEverythingTrueIsTrue()
    {
        $this->assertTrue(all([true, true, true, true], Functions::identity));
    }

    public function testJustOneTrueIsFalse()
    {
        $this->assertFalse(all([true, false, false, false], Functions::identity));
    }

    public function testEverythingFalseIsFalse()
    {
        $this->assertFalse(all([false, false, false, false], Functions::identity));
    }
}
