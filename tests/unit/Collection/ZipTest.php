<?php

namespace Test\Apply\Unit\Collection;

use Apply\Collection\Sequence\Sequence;
use function Apply\Collection\Imperative\zip;
use Codeception\Test\Unit;

class ZipTest extends Unit
{
    public function testZip(): void
    {
        $a = [1, 2, 3];
        $b = [4, 5, 6];

        $this->assertSame([[1, 4], [2, 5], [3, 6]], iterator_to_array(zip($a, $b)));
    }

    public function testWithDifferingLengths(): void
    {
        $a = [1,2,3,4];
        $b = [1,2];
        $this->assertSame([[1,1],[2,2]], iterator_to_array(zip($a, $b)));
    }

    public function testWithSequence(): void
    {
        $a = [1,2,3,4];
        $b = Sequence::fromThenTo(1, 2);
        $this->assertSame([[1,1],[2,2],[3,3],[4,4]], iterator_to_array(zip($a, $b)));

    }
}
