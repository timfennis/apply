<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

/**
 * sortOn :: (a -> b) -> [a] -> [a].
 *
 * Sorts a collection with a user-defined function, optionally preserving array keys
 */
function sortOn(callable $f): callable
{
    return sortBy(static fn ($left, $right) => $f($left) <=> $f($right));
}
