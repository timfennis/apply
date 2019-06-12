<?php


namespace Functional\Collection;

use Codeception\Test\Unit;
use function Apply\Collection\Curried\foldl1;

class Foldl1Test extends Unit
{

    public function testWithThree()
    {
        $list = [1,2,3];
        $this->assertEquals(6, foldl1([$this, 'add'])($list));
    }

    public function testWithTwo()
    {
        $list = [1,2];
        $this->assertEquals(3, foldl1([$this, 'add'])($list));
    }

    public function testWithOne()
    {
        $list = [1];
        $this->assertEquals(1, foldl1([$this, 'add'])($list));
    }

    public function add($a, $b)
    {
        return $a + $b;
    }

}