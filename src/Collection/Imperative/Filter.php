<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\filter as curriedFilter;
use Generator;

/**
 * @param callable $predicate
 *
 * @param iterable $collection
 *
 * @return Generator
 */
function filter(callable $predicate, iterable $collection): Generator
{
    yield from curriedFilter($predicate)($collection);
}