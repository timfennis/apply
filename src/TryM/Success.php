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

    public function flatMap(callable $f): TryM
    {
        return $f($this->value);
    }

    public function isSuccess(): bool
    {
        return true;
    }

    public function isFailure(): bool
    {
        return false;
    }

    public function fold(callable $ifFailure, callable $ifSuccess)
    {
        return $ifSuccess($this->value);
    }
}