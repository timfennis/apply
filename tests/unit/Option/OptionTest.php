<?php

declare(strict_types=1);

namespace Test\Apply\Option;

use Apply\Option\None;
use Apply\Option\Option;
use Apply\Option\Some;
use Codeception\Test\Unit;
use function Apply\Option\just;

class OptionTest extends Unit
{
    public function testIsDefinedAndIsEmpty()
    {
        $option = just(5);
        $this->assertTrue($option->isDefined());
        $this->assertFalse($option->isEmpty());

        $nothing = None::create();
        $this->assertTrue($nothing->isEmpty());
        $this->assertFalse($nothing->isDefined());
    }

    public function testOrElse()
    {
        $five = just(5);
        $six = just(6);
        $notSeven = None::create();

        $this->assertSame($five, $five->orElse($notSeven));
        $this->assertSame($five, $five->orElse($six));
        $this->assertSame($five, $notSeven->orElse($five));
    }

    public function testGetOrCall()
    {
        $five = just(5);

        $this->assertSame(5, $five->getOrCall(fn() => 6));
        $this->assertSame(6, None::create()->getOrCall(fn() => 6));
    }

    public function testFilter()
    {
        $option = just(10);
        $this->assertInstanceOf(Some::class, $option->filter(fn($v) => $v > 5));
        $this->assertInstanceOf(None::class, $option->filter(fn($v) => $v > 15));
    }

    public function testMap()
    {
        $option = just(5);

        $this->assertInstanceOf(Some::class, $option->map(fn ($v) => $v + 3));
        $this->assertEquals(8, $option->map(fn ($v) => $v + 3)->orNull());

        // Assert that the lambda is not called for None
        $this->assertInstanceOf(None::class, None::create()->map(fn($x) => $this->fail('This lambda should not be called')));
    }

    public function testFlatMap()
    {
        $this->assertInstanceOf(None::class, None::create()->flatMap(fn() => just(10)));
        $this->assertInstanceOf(None::class, just(5)->flatMap(fn() => None::create()));
        $this->assertInstanceOf(Some::class, just(5)->flatMap(fn($five) => just($five + 3)));
    }

    /**
     * @dataProvider invalidReturnValueProvider
     */
    public function testThatInvalidTypesCannotBeReturnedFromLambdaPassedToFlatMap($invalidReturnValue)
    {
        $this->expectException(\Apply\Exception\InvalidStateException::class);
        just(5)->flatMap(fn() => $invalidReturnValue);

    }

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

    public function invalidReturnValueProvider()
    {
        return [
            [1],
            ['string'],
            [new \stdClass()],
            [1.1],
            [false],
        ];
    }
}
