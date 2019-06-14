<?php

namespace Apply\Collection\Curried;

use function Apply\Collection\toArray;
use Traversable;

/**
 * sort :: (a -> a -> Ordering) -> [a] -> [a]
 *
 * Sorts a collection with a user-defined function, optionally preserving array keys
 *
 * @param callable $sortFunction
 *
 * @return callable
 */
function sortBy(callable $sortFunction): callable
{
    return static function (iterable $collection) use ($sortFunction) : iterable {

        $array = $collection instanceof Traversable
            ? toArray($collection)
            : $collection;


        usort($array, $sortFunction);

        return $array;
    };
}

