<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\take;
use Codeception\Test\Unit;

class TakeTest extends Unit
{
    // tests
    public function testTakeFromLongerList(): void
    {
        $list = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $outList = take($list, 5);

        $this->assertSame([1, 2, 3, 4, 5], iterator_to_array($outList, false));
    }

    public function testTakeWholeList(): void
    {
        $list = [1, 2, 3, 4, 5];

        $outList = take($list, 5);

        $this->assertSame([1, 2, 3, 4, 5], iterator_to_array($outList, false));
    }

    public function testTakeMoreThenList(): void
    {
        $list = [1, 2, 3, 4, 5];

        $outList = take($list, 100);

        $this->assertSame([1, 2, 3, 4, 5], iterator_to_array($outList, false));
    }
}
