<?php


namespace Test\Apply\Unit\Collection;


use Apply\Collection\LazyIterator;
use Apply\Collection\Sequence\Sequence;
use Codeception\Test\Unit;
use Exception;
use Iterator;
use function Apply\Collection\head;
use function Apply\Collection\Imperative\map;
use function Apply\Collection\iteratorOf;

class LazyIteratorTest extends Unit
{
    public function testThatTheLazyIteratorComposesWithoutAccessingTheCallable()
    {
        $iterator = new LazyIterator(static function () {
            throw new Exception();
        });

        $mapped = map($iterator, static function ($a) {
            return $a + 1;
        });

        $this->assertInstanceOf(Iterator::class, $mapped);
    }

    /**
     * @dataProvider dataProvider
     *
     * @param $collection
     * @param $expectedHead
     */
    public function testThatTheLazyIteratorDoesActuallyWork($collection, $expectedHead)
    {
        $iterator = new LazyIterator(static function () use (&$collection) {
            return $collection;
        });

        $this->assertSame($expectedHead, head($iterator));
    }

    public function dataProvider()
    {
        return [
            [[1,2,3], 1],
            [Sequence::fromThenTo(1,2), 1],
            [iteratorOf([1,2,3]), 1],
        ];
    }
}