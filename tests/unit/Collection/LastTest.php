<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\iteratorOf;
use function Apply\Collection\last;
use Apply\Exception\InvalidArgumentException;
use ArrayIterator;
use Codeception\Test\Unit;

class LastTest extends Unit
{
    /**
     * @dataProvider dataProvider
     *
     * @param mixed $expectedResult
     */
    public function testLast(iterable $input, $expectedResult)
    {
        $this->assertSame($expectedResult, last($input));
    }

    /**
     * @dataProvider emptyDataProvider
     */
    public function testThatItThrowsErrorsOnEmptyCollection(iterable $input)
    {
        $this->expectExceptionObject(new InvalidArgumentException('Last cannot operate on an empty list'));
        last($input);
    }

    public function dataProvider()
    {
        return [
            [[1, 2, 3, 4, 5, 6, 7, 8, 10], 10],
            [[1], 1],
            [iteratorOf([1, 2, 3, 4, 5]), 5],
            [iteratorOf([1]), 1],
        ];
    }

    public function emptyDataProvider()
    {
        return [
            [[]],
            [iteratorOf([])],
            [new ArrayIterator([])],
        ];
    }
}
