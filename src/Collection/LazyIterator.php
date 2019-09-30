<?php


namespace Apply\Collection;

use ArrayIterator;
use Iterator;

class LazyIterator implements Iterator
{
    /** @var Iterator */
    private $internalIterator;

    /** @var callable */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    private function init(): void
    {
        if ($this->internalIterator === null) {
            $value = ($this->callable)();

            if ($value instanceof Iterator) {
                $this->internalIterator = $value;
            } elseif (is_array($value)) {
                $this->internalIterator = new ArrayIterator($value);
            } else {
                $this->internalIterator = new ArrayIterator([$value]);
            }
        }
    }

    public function current()
    {
        $this->init();
        return $this->internalIterator->current();
    }


    public function next()
    {
        $this->init();
        $this->internalIterator->next();
    }


    public function key()
    {
        $this->init();
        return $this->internalIterator->key();
    }


    public function valid()
    {
        $this->init();
        return $this->internalIterator->valid();
    }


    public function rewind()
    {
        $this->init();
        $this->internalIterator->rewind();
    }
}
