<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\cons;
use function Apply\Collection\toArray;
use Codeception\Test\Unit;

class ConsTest extends Unit
{
    /**
     * @dataProvider consProvider
     *
     * @param $x
     */
    public function testCons($x, array $xs, array $result)
    {
        $this->assertSame($result, toArray(cons($x, $xs)));
    }

    public function consProvider()
    {
        return [
            [1, [2, 3, 4], [1, 2, 3, 4]],
            ['this', ['is', 'awesome'], ['this', 'is', 'awesome']],
        ];
    }
}
