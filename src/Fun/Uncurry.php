<?php

namespace Apply\Fun;

/**
 * Transforms a curried function $fn into an uncurried function
 *
 * @param callable $fn
 *
 * @return callable
 */
function uncurry(callable $fn): callable
{
    return static function () use ($fn) {
        foreach (func_get_args() as $argument) {
            $fn = $fn($argument);
        }
    };
}
