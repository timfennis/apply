<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\head;
use function Apply\Collection\Imperative\drop;
use Apply\Collection\Sequence\Sequence;
use function Apply\Collection\toArray;
use Codeception\Test\Unit;

class DropTest extends Unit
{
    /**
     * @dataProvider dropProvider
     *
     * @covers ::\Apply\Collection\Imperative\drop()
     * @covers ::\Apply\Collection\Curried\drop()
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
            [[1, 2, 3, 4, 5, 6, 7, 8, 9], 5, [6, 7, 8, 9]],
        ];
    }
}
