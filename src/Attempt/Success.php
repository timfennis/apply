<?php

declare(strict_types=1);

namespace Apply\Attempt;

use Apply\Either\Either;
use Apply\Either\Right;

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

    public function toEither(?callable $onLeft = null): Either
    {
        return new Right($this->value);
    }
}
