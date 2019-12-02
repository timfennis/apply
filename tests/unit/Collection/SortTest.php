<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\sortBy;
use function Apply\Collection\Imperative\sortOn;
use Apply\Collection\Sequence\Sequence;
use function Apply\Collection\sort;
use function Apply\Fun\Curried\operator;
use function Apply\Fun\uncurry;
use Codeception\Test\Unit;

class SortTest extends Unit
{
    public function testRegularSortWithNumbers(): void
    {
        $a = [5, 3, 4, 2, 8, 1];
        $this->assertSame([1, 2, 3, 4, 5, 8], sort($a));
    }

    public function testRegularSortWithCharacters(): void
    {
        $this->assertSame(['a', 'b', 'c'], sort(['b', 'a', 'c']));
        $this->assertSame(['B', 'a', 'c'], sort(['a', 'c', 'B']));
    }

    public function testRegularSortWithStrings(): void
    {
        $this->assertSame(['Bart', 'Michael', 'Tim'], sort(['Tim', 'Bart', 'Michael']));
    }

    public function testSortOn(): void
    {
        $list = [
            ['value' => 3],
            ['value' => 2],
            ['value' => 8],
            ['value' => 1],
        ];

        $accessor = static function ($item) {
            return $item['value'];
        };

        $this->assertSame([
            ['value' => 1],
            ['value' => 2],
            ['value' => 3],
            ['value' => 8],
        ], sortOn($list, $accessor));
    }

    public function testSortBy(): void
    {
        $list = [-8, -6, -4, -2, 1, 3, 5, 7];
        $sorter = static function ($l, $r) {
            return abs($l) <=> abs($r);
        };

        $this->assertSame([1, -2, 3, -4, 5, -6, 7, -8], sortBy($list, $sorter));
    }

    public function testSortByWithSequence(): void
    {
        $this->assertSame([1, 2, 3, 4, 5, 6], sortBy(Sequence::fromThenTo(1, 2, 6), uncurry(operator('<=>'))));
    }
}
