<?php

declare(strict_types=1);

namespace Apply\Exception;

use JetBrains\PhpStorm\Pure;
use RuntimeException;

class InvalidStateException extends RuntimeException
{
    #[Pure]
    public static function invalidCallableReturnType(string $typeExpected, string $typeGiven): InvalidStateException
    {
        return new self("callable must return a(n) $typeExpected but $typeGiven was returned");
    }
}
