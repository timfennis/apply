<?php

declare(strict_types=1);

namespace Apply\Fun;

/**
 * Transforms a curried function $fn into an uncurried function.
 */
function uncurry(callable $fn): callable
{
    return static function () use ($fn) {
        foreach (func_get_args() as $argument) {
            $fn = $fn($argument);
        }
    };
}
