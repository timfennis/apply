<?php

declare(strict_types=1);

namespace Apply\Collection\Sequence;

use Apply\Exception\InvalidArgumentException;
use Iterator;

class Sequence implements Iterator
{
    private int $start;

    private int $value;

    private ?int $limit;

    private int $step;

    public function __construct(int $from, ?int $to = null, int $step = 1)
    {
        if (null !== $to && null !== $from && $to < $from) {
            throw new InvalidArgumentException('Sequences cannot count down');
        }

        $this->step = $step;
        $this->start = $from;
        $this->value = $from;
        $this->limit = $to;
    }

    public function current()
    {
        return $this->value;
    }

    public function next()
    {
        $this->value += $this->step;
    }

    public function key()
    {
        return $this->value - $this->start;
    }

    public function valid()
    {
        return null === $this->limit || $this->limit >= $this->value;
    }

    public function rewind()
    {
        $this->value = $this->start;
    }

    public static function fromThenTo(int $from, int $then, ?int $to = null): Sequence
    {
        return new self($from, $to, $then - $from);
    }
}
