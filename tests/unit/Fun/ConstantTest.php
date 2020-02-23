<?php

declare(strict_types=1);

namespace Tests\Apply\Fun;

use Codeception\Test\Unit;
use function Apply\Fun\constant;

class ConstantTest extends Unit
{
    /**
     * @test
     */
    public function it_returns_its_argument()
    {
        $this->assertSame('foo', constant('foo')());
    }
}