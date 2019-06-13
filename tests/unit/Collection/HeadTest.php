<?php

namespace Apply\Collection;

use Codeception\Test\Unit;
use InvalidArgumentException;

class HeadTest extends Unit
{
    public function testWithACoupleOfElements(): void
    {
        $this->assertSame(1, head([1,2,3]));
    }

    public function testWithSingleElement(): void
    {
        $this->assertSame(1, head([1]));
    }

    public function testErrorWithEmptyList(): void
    {
        $this->expectExceptionObject(new InvalidArgumentException('Head cannot operate on an empty list'));
        head([]);
    }
}