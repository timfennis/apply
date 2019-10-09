<?php


namespace Test\Apply\Unit\Collection;

use Apply\Collection\Sequence\Sequence;
use Codeception\Test\Unit;
use function Apply\Collection\head;
use function Apply\Collection\Imperative\drop;
use function Apply\Collection\toArray;

class DropTest extends Unit
{
    /**
     * @dataProvider dropProvider
     *
     * @covers ::\Apply\Collection\Imperative\drop()
     * @covers ::\Apply\Collection\Curried\drop()
     *
     * @param array $list
     * @param int $amount
     * @param array $result
     */
    public function testThatItDrops(array $list, int $amount, array $result)
    {
        $this->assertSame($result, toArray(drop($list, $amount)));
    }

    /**
     * @covers ::\Apply\Collection\Imperative\drop()
     * @covers ::\Apply\Collection\Curried\drop()
     */
    public function testDroppingFromSequence()
    {
        $this->assertSame(11, head(drop(Sequence::fromThenTo(1, 2), 10)));
    }

    public function dropProvider()
    {
        return [
            [[1,2,3,4,5,6,7,8,9], 5, [6,7,8,9]],
        ];
    }
}
