<?php

declare(strict_types=1);

namespace Tests\Apply\Fun;

use Codeception\Test\Unit;
use function Apply\Fun\identity;

class IdentityTest extends Unit
{
    /**
     * @test
     */
    public function it_preserves_identity()
    {
        $this->assertSame('foo', identity('foo'));
    }
}