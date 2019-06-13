<?php

namespace Test\Apply\Functional\Collection;

use function Apply\Collection\Imperative\zip;
use function Apply\Collection\Imperative\zipWith;
use Codeception\Test\Unit;

class ZipWithTest extends Unit
{
    public function testZipWith(): void
    {
        $a = [1, 2, 3];
        $b = [4, 5, 6];

        $this->assertSame([5, 7, 9], iterator_to_array(zipWith($a, $b, static function ($a, $b) { return $a + $b; })));
    }
}