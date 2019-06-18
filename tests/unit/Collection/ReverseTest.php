<?php

namespace Test\Apply\Functional\Collection;

use function Apply\Collection\reverse;
use Apply\Collection\StringIterator;
use function Apply\Collection\toArray;
use ArrayIterator;
use Codeception\Test\Unit;

class ReverseTest extends Unit
{
    public function testWithArray()
    {
        $this->assertSame([3,2,1], toArray(reverse([1,2,3])));
    }

    public function testWithStringIterator()
    {
        $this->assertSame('!dlroW olleH', implode('', toArray(reverse(new StringIterator('Hello World!')))));
    }

    public function testWithArrayIterator()
    {
        $this->assertSame([5,4,3,2,1], toArray(reverse(new ArrayIterator([1,2,3,4,5]))));
    }
}
