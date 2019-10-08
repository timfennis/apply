<?php

namespace Test\Apply\Unit\Collection;

use Apply\Collection\Sequence\Sequence;
use Codeception\Test\Unit;
use function Apply\Collection\Imperative\zipWith;

class ZipWithTest extends Unit
{
    public function testZipWith(): void
    {
        $a = [1, 2, 3];
        $b = [4, 5, 6];

        $this->assertSame([5, 7, 9], iterator_to_array(zipWith($a, $b, static function ($a, $b) {
            return $a + $b;
        })));
    }

    public function testWithSequence(): void
    {
        $concat = static function($a, $b) {
            return $a . $b;
        };

        $a = ['Prefix: ', '1: ', 'B: '];
        $b = Sequence::fromThenTo(1,2);

        $this->assertSame([
            'Prefix: 1',
            '1: 2',
            'B: 3',
        ], iterator_to_array(zipWith($a, $b, $concat)));
    }
}
