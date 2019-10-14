<?php


namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Curried\filter;
use function Apply\Collection\Imperative\map;
use function Apply\Collection\Curried\map as mapC;
use Codeception\Test\Unit;
use function Apply\Collection\toArray;

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

    public function testMyCrazyExample()
    {
        $list = [[1,2,3],[4,5,6],[7,8,9]];
        $isOdd = function($n) { return  $n % 2 == 1; } ;

        $r = mapC(filter($isOdd))($list);

        $this->assertSame([[1,3],[5],[7,9]], toArray(map($r, 'Apply\Collection\toArray')));
    }
}
