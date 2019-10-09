<?php


namespace Test\Apply\Unit\Collection;

use Codeception\Test\Unit;
use function Apply\Collection\Imperative\cons;
use function Apply\Collection\toArray;

class ConsTest extends Unit
{
    /**
     * @dataProvider consProvider
     * @param $x
     * @param array $xs
     * @param array $result
     */
    public function testCons($x, array $xs, array $result)
    {
        $this->assertSame($result, toArray(cons($x, $xs)));
    }

    public function consProvider()
    {
        return [
            [1, [2,3,4], [1,2,3,4]],
            ['this', ['is', 'awesome'], ['this', 'is', 'awesome']],
        ];
    }
}
