<?php

namespace Apply\Collection;

/**
 * sort :: [a] -> [a]
 *
 * @param iterable $collection
 *
 * @return iterable
 */
function sort(iterable $collection): iterable
{
    return Curried\sortBy(static function ($left, $right) { return $left <=> $right; })($collection);
}

