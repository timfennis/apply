<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\flatMap;
use function Apply\Fun\constant;
use Apply\Functions;
use Codeception\Test\Unit;

class FlatMapTest extends Unit
{
    // tests
    public function testWithSimpleListOfLists(): void
    {
        $list = [[1, 2, 3], [4, 5, 6], [7, 8, 9]];

        $outList = flatMap($list, Functions::identity);

        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], iterator_to_array($outList, false));
    }

    public function testWithEmptyLists(): void
    {
        $list = [[], [], []];

        $outList = flatMap($list, Functions::identity);

        $this->assertSame([], iterator_to_array($outList, false));
    }

    public function testWitHEmptyAndNonEmptyLists(): void
    {
        $list = [[1, 2, 3], [], [4, 5, 6], []];

        $outList = flatMap($list, Functions::identity);

        $this->assertSame([1, 2, 3, 4, 5, 6], iterator_to_array($outList, false));
    }

    public function testFunStuff()
    {
        $list = [1, 2, 3];

        $outList = flatMap($list, constant([1, 2, 3]));

        $this->assertSame([1, 2, 3, 1, 2, 3, 1, 2, 3], iterator_to_array($outList, false));
    }
}
