<?php


namespace Test\Apply\Fun;


use Codeception\Test\Unit;
use function Apply\Collection\toArray;
use function Apply\Fun\Curried\operator;

class OperatorTest extends Unit
{
    /**
     * @dataProvider operatorProvider
     *
     * @param mixed $left
     * @param string $symbol
     * @param mixed $right
     * @param mixed $expectedResult
     */
    public function testOperator($left, $symbol, $right, $expectedResult)
    {
        $actualResult = operator($symbol)($left)($right);
        $this->assertSame($actualResult, $expectedResult, "Failed asserting that $left $symbol $right [ $actualResult ] evaluates to $expectedResult");
    }

    public function _operatorProvider()
    {
        /** @noinspection PhpExpressionWithSameOperandsInspection */
        $operators = ['*','/','%','+','-','.','<','<=','>','>=','==','!=','===','!==','&&','||','<=>'];
        $values = ['1','2','-1','1.5'];

        foreach ($operators as $operator) {
            foreach ($values as $left) {
                foreach ($values as $right) {
                    yield [$left, $operator, $right, eval('return ' . $left . ' ' . $operator . ' ' . $right .';')];
                }
            }
        }
    }

    public function operatorProvider()
    {
        return toArray($this->_operatorProvider());
    }
}