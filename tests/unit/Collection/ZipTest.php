<?php

namespace Test\Apply\Functional\Collection;

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
}