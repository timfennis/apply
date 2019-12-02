<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\filter;
use function Apply\Collection\Imperative\take;
use Apply\Collection\Sequence\Sequence;
use function Apply\Collection\toArray;
use Codeception\Test\Unit;

class FilterTest extends Unit
{
    /**
     * @dataProvider filterDataProvider
     */
    public function testFiltering(array $input, array $expectedResult)
    {
        $result = filter($input, static function ($value) {
            return $value > 5;
        });

        $this->assertSame($expectedResult, toArray($result));
    }

    public function testThatItDoesntCrashWithInfiniteSequences()
    {
        $result = filter(Sequence::fromThenTo(1, 2), static function (int $number) {
            return $number < 10;
        });

        $this->assertEquals([1, 2, 3], toArray(take($result, 3)));
    }

    public function filterDataProvider()
    {
        return [
            [[1, 2, 3, 4, 5, 6, 7, 8, 9], [6, 7, 8, 9]],
            [[1, 2, 3, 4], []],
            [[], []],
            [[10], [10]],
        ];
    }
}
