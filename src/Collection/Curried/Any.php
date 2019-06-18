<?php

namespace Apply\Collection\Curried;

/**
 * any :: (a -> Bool) -> [a] -> Bool
 *
 * Applied to a predicate and a list, any determines if any element of the list satisfies the predicate. For the result
 * to be False, the list must be finite; True, however, results from a True value for the predicate applied to an
 * element at a finite index of a finite or infinite list.
 *
 * @param callable $predicate
 *
 * @return callable
 */
function any(callable $predicate): callable
{
    return static function (iterable $collection) use ($predicate) : bool {
        foreach ($collection as $value) {
            if (true === $predicate($value)) {
                return true;
            }
        }

        return false;
    };
}
