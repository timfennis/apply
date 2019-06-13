<?php

namespace Apply\Collection;

use Codeception\Test\Unit;
use InvalidArgumentException;

class TailTest extends Unit
{
    public function testWithPrettyLongList(): void
    {
        $list = [1,2,3,4,5];
        $out = tail($list);

        $this->assertSame([2,3,4,5], iterator_to_array($out));
    }

    public function testWithSingleElementList(): void
    {
        $this->assertSame([], iterator_to_array(tail([1])));
    }

    public function testErrorWithEmptyList(): void
    {
        $a = tail([]);

        $this->expectExceptionObject(new InvalidArgumentException('Tail cannot operate on an empty list'));
        iterator_to_array($a);
    }
}