<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

/**
 * first :: (a -> Bool) -> [a] -> ?a.
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
