<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Curried\foldl1;
use Apply\Exception\InvalidArgumentException;
use Codeception\Test\Unit;

class Foldl1Test extends Unit
{
    public function testWithAThreeElementList()
    {
        $list = [1, 2, 3];
        $this->assertEquals(6, foldl1([$this, 'add'])($list));
    }

    public function testWithATwoElementList()
    {
        $list = [1, 2];
        $this->assertEquals(3, foldl1([$this, 'add'])($list));
    }

    public function testWithOneElementList()
    {
        $list = [1];
        $this->assertEquals(1, foldl1([$this, 'add'])($list));
    }

    public function testReturnsNullWhenGivenAnEmptyList()
    {
        $this->expectExceptionObject(new InvalidArgumentException('foldl1 does not work on empty lists'));

        $list = [];
        $this->assertEquals(null, foldl1([$this, 'add'])($list));
    }

    public function add($a, $b)
    {
        return $a + $b;
    }
}
