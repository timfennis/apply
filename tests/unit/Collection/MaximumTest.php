<?php


namespace Test\Apply\Functional\Collection;


use Codeception\Test\Unit;
use function Apply\Collection\maximum;

class MaximumTest extends Unit
{
    /**
     * @dataProvider listProvider
     *
     * @param array $list
     * @param int $max
     */
    public function testThatItReturnsTheHighestValueFromAnyPositionInTheList(array $list, int $max): void
    {
        $this->assertSame($max, maximum($list));
    }

    public function listProvider()
    {
        return [
            [[1,2,3], 3],
            [[1,3,2], 3],
            [[3,2,1], 3],
        ];
    }
}