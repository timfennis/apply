<?php

declare(strict_types=1);

namespace Apply\Collection;

use Iterator;
use JetBrains\PhpStorm\Pure;

class BinaryIterator implements Iterator
{
    private string $string;

    private int $pos = 0;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    #[Pure]
    public function current()
    {
        return substr($this->string, $this->pos, 1);
    }

    public function next()
    {
        ++$this->pos;
    }

    public function key()
    {
        return $this->pos;
    }

    #[Pure]
    public function valid()
    {
        return $this->pos < strlen($this->string);
    }

    public function rewind()
    {
        $this->pos = 0;
    }
}
