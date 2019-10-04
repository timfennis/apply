<?php


namespace Test\Apply\Functional\Collection;


use Codeception\Test\Unit;
use function Apply\Collection\Imperative\lastOrNull;

class LastOrNullTest extends Unit
{
    /**
     * @dataProvider lastOrNullDataProvider
     *
     * @param iterable $collection
     * @param int|null $expectedResult
     */
    public function testLastOrNull(iterable $collection, ?int $expectedResult)
    {
        $this->assertSame($expectedResult, lastOrNull($collection, static function ($num) {
            return $num > 5;
        }));
    }

    public function lastOrNullDataProvider()
    {
        return [
            [[4,5,6],6],
            [[], null],
            [[1,2,3], null]
        ];
    }
}