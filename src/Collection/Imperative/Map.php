<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\map as curriedMap;
use Generator;

/**
 * @param iterable $collection
 * @param callable $callback
 *
 * @return Generator
 */
function map(iterable $collection, callable $callback): Generator
{
    yield from curriedMap($callback)($collection);
}
