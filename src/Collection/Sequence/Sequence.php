<?php


namespace Apply\Collection\Sequence;

use Iterator;
use Apply\Exception\InvalidArgumentException;

class Sequence implements Iterator
{
    /** @var int */
    private $start;

    /** @var int */
    private $value;

    /** @var int|null */
    private $limit;

    /** @var int */
    private $step;

    public function __construct(int $from, ?int $to = null, int $step = 1)
    {
        if ($to !== null  && $from !== null && $to < $from) {
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
        return $this->limit === null || $this->limit >= $this->value;
    }

    public function rewind()
    {
        $this->value = $this->start;
    }

    public static function fromThenTo(int $from, int $then, ?int $to = null): Sequence
    {
        return new self($from, $to, $then-$from);
    }
}
