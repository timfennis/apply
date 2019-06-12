<?php


namespace Apply\TryM;


final class Success extends TryM
{
    /** @var mixed */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function flatMap(callable $callable): TryM
    {
        return $callable($this->value);
    }

    public function get()
    {
        return $this->value;
    }
}