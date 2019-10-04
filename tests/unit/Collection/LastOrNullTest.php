<?php


namespace Test\Apply\Functional\Collection;


use Apply\Collection\Sequence\Sequence;
use Codeception\Test\Unit;
use function Apply\Collection\Imperative\lastOrNull;
use function Apply\Collection\iteratorOf;

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

    public function testThatArrayPerformanceIsOptimal()
    {
        $timesCalled = 0;
        $array = [1, 2, 3, 4, 5, 6, 7, 8, 10];
        $function = static function ($a) use (&$timesCalled) {
            $timesCalled++;
            return true;
        };

        $result = lastOrNull($array, $function);

        $this->assertSame(10, $result);
        $this->assertSame(1, $timesCalled);
    }

    public function lastOrNullDataProvider()
    {
        return [
            [[4, 5, 6], 6],
            [[], null],
            [[1, 2, 3], null],
            [Sequence::fromThenTo(1, 2, 10), 10],
            [iteratorOf([9, 8, 7, 6, 5, 4, 3, 2, 1]), 6],
        ];
    }
}