<?php

namespace Apply\Collection\Imperative;

/**
 * @param iterable $collection
 * @param callable $sortFunction Function that takes two arguments and returns -1, 0, or 1
 *
 * @return iterable
 */
function sortBy(iterable $collection, callable $sortFunction): iterable
{
    return \Apply\Collection\Curried\sortBy($sortFunction)($collection);
}

