<?php

declare(strict_types=1);

namespace Apply\Attempt;

use Apply\Either\Either;
use Apply\Either\Right;

/**
 * @phpstan-template T
 * @phpstan-extends Attempt<T>
 */
final class Success extends Attempt
{
    /**
     * @var mixed
     * @phpstan-var T
     */
    private $value;

    /**
     * @phpstan-param T $value
     */
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
