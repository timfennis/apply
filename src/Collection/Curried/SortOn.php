<?php

namespace Apply\Collection\Curried;

/**
 * sortOn :: (a -> b) -> [a] -> [a]
 *
 * Sorts a collection with a user-defined function, optionally preserving array keys
 *
 * @param callable $f
 *
 * @return callable
 */
function sortOn(callable $f): callable
{
    return sortBy(static function ($left, $right) use ($f) {
        return $f($left) <=> $f($right);
    });
}

