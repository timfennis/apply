<?php


namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\map;
use Codeception\Test\Unit;

class MapTest extends Unit
{
    public function testSimpleMathOperation()
    {
        $list = [1, 2, 3, 4];
        $addOne = static function ($i) {
            return $i + 1;
        };

        $outList = map($list, $addOne);

        $this->assertEquals([2, 3, 4, 5], iterator_to_array($outList));
    }
}
