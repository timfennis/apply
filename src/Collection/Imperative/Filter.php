<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\filter as curriedFilter;
use Generator;

/**
 * @param iterable $collection
 * @param callable $predicate
 *
 * @return Generator
 */
function filter(iterable $collection, callable $predicate): Generator
{
    yield from curriedFilter($predicate)($collection);
}
