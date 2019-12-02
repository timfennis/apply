<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\toArray;
use function Apply\Collection\unique;
use Codeception\Test\Unit;

class UniqueTest extends Unit
{
    /**
     * @dataProvider scalarData
     */
    public function testWithScalars(array $input, array $expectedOutput)
    {
        $this->assertSame($expectedOutput, toArray(unique($input)));
    }

    public function scalarData()
    {
        return [
            [[1, 2, 3], [1, 2, 3]],
            [[1, 1, 2, 3], [1, 2, 3]],
            [['A', 'B', 'C'], ['A', 'B', 'C']],
            [['A', 'B', 'B', 'C'], ['A', 'B', 'C']],
            [['foo', 'bar', 'baz'], ['foo', 'bar', 'baz']],
            [['foo', 'bar', 'baz', 'baz'], ['foo', 'bar', 'baz']],
            [['A', 'a'], ['A', 'a']],
            [[1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1], [1, 2]],
            [[1.0, 5.0 / 2, 2.5], [1.0, 2.5]],
        ];
    }
}
