<?php


namespace Test\Apply\Unit\Collection;


use Apply\Collection\Sequence\Sequence;
use Codeception\Test\Unit;
use function Apply\Collection\iteratorOf;

class IteratorOfTest extends Unit
{
    public function testIteratorOf()
    {
        $this->assertInstanceOf(\Iterator::class, iteratorOf([1,2,3,4,5,6,7,8,9]));
    }
}