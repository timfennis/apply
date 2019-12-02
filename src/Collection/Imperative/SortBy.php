<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

/**
 * @param callable $sortFunction Function that takes two arguments and returns -1, 0, or 1
 */
function sortBy(iterable $collection, callable $sortFunction): iterable
{
    return \Apply\Collection\Curried\sortBy($sortFunction)($collection);
}
