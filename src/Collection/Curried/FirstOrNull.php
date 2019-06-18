<?php


namespace Apply\Collection\Curried;

/**
 * first :: (a -> Bool) -> [a] -> ?a
 *
 * @param callable $predicate
 *
 * @return callable
 */
function firstOrNull(callable $predicate): callable
{
    return static function (iterable $collection) use ($predicate) {
        foreach (filter($predicate)($collection) as $item) {
            return $item;
        }

        return null;
    };
}
