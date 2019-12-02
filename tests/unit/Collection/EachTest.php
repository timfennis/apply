<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\each;
use Codeception\Test\Unit;

class EachTest extends Unit
{
    public function testEach()
    {
        $acc = 0;
        each([1, 2, 3], static function (int $num) use (&$acc) {
            $acc += $num;
        });

        $this->assertSame(6, $acc);
    }
}
