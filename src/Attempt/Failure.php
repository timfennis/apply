<?php

declare(strict_types=1);

namespace Apply\Attempt;

use Apply\Either\Either;
use Apply\Either\Left;
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

    public function toEither(?callable $onLeft = null): Either
    {
        return null === $onLeft
            ? new Left($this->error)
            : new Left($onLeft($this->error));
    }
}
