<?php


namespace Apply\Attempt;

use Throwable;

final class Failure extends Attempt
{
    /** @var Throwable */
    private $error;

    public function __construct(Throwable $error)
    {
        $this->error = $error;
    }

    public function flatMap(callable $callable): Attempt
    {
        return $this;
    }

    public function isSuccess(): bool
    {
        return false;
    }

    public function isFailure(): bool
    {
        return true;
    }

    public function fold(callable $ifFailure, callable $ifSuccess)
    {
        return $ifFailure($this->error);
    }
}
