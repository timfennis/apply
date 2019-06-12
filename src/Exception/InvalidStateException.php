<?php


namespace Apply\Exception;

use RuntimeException;

class InvalidStateException extends RuntimeException
{
    public static function invalidCallableReturnType(string $typeExpected, string $typeGiven): InvalidStateException
    {
        return new self("callable must return a(n) $typeExpected but $typeGiven was returned");
    }
}
