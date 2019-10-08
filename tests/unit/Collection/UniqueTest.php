<?php


namespace Test\Apply\Unit\Collection;


use Codeception\Test\Unit;
use function Apply\Collection\toArray;
use function Apply\Collection\unique;

class UniqueTest extends Unit
{

    /**
     * @dataProvider scalarData
     *
     * @param array $input
     * @param array $expectedOutput
     */
    public function testWithScalars(array $input, array $expectedOutput)
    {
        $this->assertSame($expectedOutput, toArray(unique($input)));
    }

    public function scalarData()
    {
        return [
            [[1,2,3], [1,2,3]],
            [[1,1,2,3], [1,2,3]],
            [['A', 'B', 'C'], ['A', 'B', 'C']],
            [['A', 'B', 'B', 'C'], ['A', 'B', 'C']],
            [['foo', 'bar', 'baz'], ['foo', 'bar', 'baz']],
            [['foo', 'bar', 'baz', 'baz'], ['foo', 'bar', 'baz']],
            [['A', 'a'], ['A', 'a']],
            [[1,1,1,1,1,1,1,1,1,2,1,1,1,1], [1,2]],
            [[1.0, 5.0/2, 2.5], [1.0,2.5]]
        ];
    }


}