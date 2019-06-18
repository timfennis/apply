<?php

namespace Apply\Collection\Curried;

/**
 * all :: (a -> Bool) -> [a] -> Bool
 *
 * Applied to a predicate and a list, all determines if all elements of the list satisfy the predicate. For the result
 * to be True, the list must be finite; False, however, results from a False value for the predicate applied to an
 * element at a finite index of a finite or infinite list.
 *
 * @param callable $predicate
 *
 * @return callable
 */
function all(callable $predicate): callable
{
    return static function (iterable $collection) use ($predicate) : bool {
        foreach ($collection as $value) {
            if (false === $predicate($value)) {
                return false;
            }
        }

        return true;
    };
}
