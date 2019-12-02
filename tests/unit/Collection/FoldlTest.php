<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\Imperative\foldl;
use Codeception\Test\Unit;

class FoldlTest extends Unit
{
    /**
     * @dataProvider additionDataProvider
     */
    public function testFoldlWithAdd(array $input, int $expectedResult)
    {
        $add = static function ($a, $b) {
            return $a + $b;
        };

        $result = foldl($input, $add, 0);

        $this->assertSame($expectedResult, $result);
    }

    public function additionDataProvider()
    {
        return [
            [[1, 2, 3, 4, 5], 15],
            [[1], 1],
            [[], 0],
        ];
    }
}
