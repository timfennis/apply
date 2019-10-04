<?php


namespace Apply\Collection;

use Iterator;

class BinaryIterator implements Iterator
{

    /** @var string */
    private $string;

    private $pos = 0;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function current()
    {
        return substr($this->string, $this->pos, 1);
    }

    public function next()
    {
        $this->pos++;
    }

    public function key()
    {
        return $this->pos;
    }

    public function valid()
    {
        return $this->pos < strlen($this->string);
    }

    public function rewind()
    {
        $this->pos = 0;
    }
}
