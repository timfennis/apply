<?php

declare(strict_types=1);

namespace Test\Apply\Option;

use Apply\Option\None;
use Apply\Option\Option;
use Apply\Option\Some;
use Codeception\Test\Unit;

class OptionTest extends Unit
{
    public function testOptionBindingSuccess()
    {
        $result = Option::binding(static function () {
            $a = yield Option::fromValue(1);
            $b = yield Option::fromValue(5);

            return $a + $b;
        });

        $this->assertInstanceOf(Some::class, $result);
        $this->assertSame(6, $result->get());
    }

    /**
     * @dataProvider optionProvider
     *
     * @param $expectedResult
     */
    public function testOptionBindingWithNoneValues(Option $a, Option $b, Option $expectedResult)
    {
        $endResult = Option::binding(static function () use ($a, $b) {
            $aResult = yield $a;
            $bResult = yield $b;

            return $aResult + $bResult;
        });

        if ($expectedResult instanceof None) {
            $this->assertInstanceOf(None::class, $endResult);
        } else {
            $this->assertSame($expectedResult->get(), $endResult->get());
        }
    }

    public function optionProvider()
    {
        return [
            [Some::fromValue(1), Some::fromValue(1), Some::fromValue(2)],
            [None::create(), Some::fromValue(1), None::create()],
            [Some::fromValue(1), None::create(), None::create()],
            [None::create(), None::create(), None::create()],
        ];
    }
}
