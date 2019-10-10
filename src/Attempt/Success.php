<?php


namespace Apply\Attempt;

final class Success extends Attempt
{
    /** @var mixed */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function flatMap(callable $f): Attempt
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
