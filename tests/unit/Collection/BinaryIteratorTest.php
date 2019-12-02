<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use Apply\Collection\BinaryIterator;
use function Apply\Collection\Imperative\map;
use function Apply\Collection\toArray;
use Codeception\Test\Unit;

class BinaryIteratorTest extends Unit
{
    public function testBinaryIterator(): void
    {
        $iterator = new BinaryIterator('😢');
        $this->assertSame([
            hexdec('F0'),
            hexdec('9F'),
            hexdec('98'),
            hexdec('A2'),
        ], toArray(map($iterator, static function ($a) {
            return ord($a);
        })));
    }
}
