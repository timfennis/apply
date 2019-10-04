<?php


namespace Test\Apply\Functional\Collection;


use Codeception\Test\Unit;
use function Apply\Collection\Imperative\foldl;

class FoldlTest extends Unit
{
    /**
     * @dataProvider additionDataProvider
     *
     * @param array $input
     * @param int $expectedResult
     */
    public function testFoldlWithAdd(array $input, int $expectedResult)
    {
        $add = static function ($a, $b) { return $a + $b; };

        $result = foldl($input, $add, 0);

        $this->assertSame($expectedResult, $result);
    }

    public function additionDataProvider()
    {
        return [
            [[1,2,3,4,5], 15],
            [[1], 1],
            [[], 0]
        ];
    }
}