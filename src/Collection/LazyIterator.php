<?php

declare(strict_types=1);

namespace Apply\Collection;

use ArrayIterator;
use Iterator;

class LazyIterator implements Iterator
{
    private ?Iterator $internalIterator = null;

    /** @var callable */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    private function getIterator(): Iterator
    {
        if (null === $this->internalIterator) {
            $value = ($this->callable)();

            if ($value instanceof Iterator) {
                $this->internalIterator = $value;
            } elseif (is_array($value)) {
                $this->internalIterator = new ArrayIterator($value);
            } else {
                $this->internalIterator = new ArrayIterator([$value]);
            }
        }

        return $this->internalIterator;
    }

    public function current()
    {
        return $this->getIterator()->current();
    }

    public function next()
    {
        $this->getIterator()->next();
    }

    public function key()
    {
        return $this->getIterator()->key();
    }

    public function valid()
    {
        return $this->getIterator()->valid();
    }

    public function rewind()
    {
        $this->getIterator()->rewind();
    }
}
