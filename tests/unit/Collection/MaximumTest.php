<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\maximum;
use Codeception\Test\Unit;

class MaximumTest extends Unit
{
    /**
     * @dataProvider listProvider
     */
    public function testThatItReturnsTheHighestValueFromAnyPositionInTheList(array $list, int $max): void
    {
        $this->assertSame($max, maximum($list));
    }

    public function listProvider()
    {
        return [
            [[1, 2, 3], 3],
            [[1, 3, 2], 3],
            [[3, 2, 1], 3],
        ];
    }
}
