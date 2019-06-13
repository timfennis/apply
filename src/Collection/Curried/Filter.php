<?php


namespace Apply\Collection\Curried;


use Generator;

/**
 * filter :: (a -> Bool) -> [a] -> [a]
 *
 * filter, applied to a predicate and a list, returns the list of those elements that satisfy the predicate; i.e.,
 *
 * filter(fn($i) => $i > 5, [4,5,6,7]) === [6,7]
 *
 * @param callable $predicate
 *
 * @return callable
 */
function filter(callable $predicate): callable
{
    return static function (iterable $collection) use ($predicate) : Generator {
        foreach ($collection as $item) {
            if ($predicate($item) === true) {
                yield $item;
            }
        }
    };
}