<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\firstOrNull;
use Apply\Collection\Sequence\Sequence;
use Codeception\Test\Unit;

class FirstOrNullTest extends Unit
{
    /**
     * @dataProvider firstOrNullDataProvider
     *
     * @param array $collection
     * @param $expectedResult
     */
    public function testFirstOrNull(iterable $collection, ?int $expectedResult)
    {
        $result = firstOrNull($collection, static function (int $number) {
            return $number > 5;
        });

        $this->assertEquals($result, $expectedResult);
    }

    public function firstOrNullDataProvider()
    {
        return [
            [[4, 5, 6], 6],
            [[1, 2, 3], null],
            [[], null],
            [[11, 12, 13], 11],
            [Sequence::fromThenTo(10, 1), 10],
        ];
    }
}
