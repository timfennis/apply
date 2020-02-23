<?php

declare(strict_types=1);

namespace Tests\Apply\Fun;

use Codeception\Test\Unit;
use function Apply\Fun\Curried\compose as curriedCompose;
use function Apply\Fun\Imperative\compose as imperativeCompose;

class ComposeTest extends Unit
{
    public function testThatItCorrectlyComposesTwoFunctionsWithOneParameter()
    {
        $mul2 = fn($i) => $i * 2;
        $sub10 = fn($i) => $i - 10;

        $cur = curriedCompose($mul2)($sub10);
        $imp = imperativeCompose($mul2, $sub10);

        $this->assertSame(20, $cur(20));
        $this->assertSame(20, $imp(20));
    }

    public function testThatItCorrectlyComposesFunctionsWithMultipleParameters()
    {
        $add = fn($a) => fn($b) => $a + $b;
        $mul2 = fn($a) => $a * 2;

        $composition = curriedCompose($add)($mul2);

        $this->assertSame(25, $composition(10)(5));
    }
}