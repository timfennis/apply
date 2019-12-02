<?php

declare(strict_types=1);

namespace Test\Apply\Collection\Sequence;

use function Apply\Collection\Imperative\take;
use Apply\Collection\Sequence\Sequence;
use Apply\Exception\InvalidArgumentException;
use Codeception\Test\Unit;

class SequenceTest extends Unit
{
    public function testInfiniteSequence(): void
    {
        $seq = new Sequence(1);
        $list = take($seq, 5);

        $this->assertSame([1, 2, 3, 4, 5], iterator_to_array($list, false));
    }

    public function testLimitedSequence(): void
    {
        $seq = new Sequence(1, 10);
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], iterator_to_array($seq, false));
    }

    public function testNegativeSequence(): void
    {
        $seq = new Sequence(-5, 5);
        $this->assertSame([-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5], iterator_to_array($seq, false));
    }

    public function testErrorOnInvalidSequence(): void
    {
        $this->expectExceptionObject(new InvalidArgumentException('Sequences cannot count down'));
        $seq = new Sequence(1, -1);
    }

    public function testSingleItemSequence(): void
    {
        $seq = new Sequence(1, 1);
        $this->assertSame([1], iterator_to_array($seq, false));
    }

    public function testStepSizeThatFits(): void
    {
        $seq = new Sequence(1, 9, 2);
        $this->assertSame([1, 3, 5, 7, 9], iterator_to_array($seq, false));
    }

    public function testWithStepSizeThatDoesNotFit(): void
    {
        $seq = new Sequence(1, 9, 7);
        $this->assertSame([1, 8], iterator_to_array($seq, false));
    }

    public function testFromThenToConstructor(): void
    {
        $seq = Sequence::fromThenTo(1, 8, 9);
        $this->assertSame([1, 8], iterator_to_array($seq, false));
    }
}
