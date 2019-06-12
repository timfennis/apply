<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\flatMap as curriedFlatMap;
use Generator;

/**
 * @param iterable $collection
 * @param callable $callback
 *
 * @return Generator
 */
function flatMap(iterable $collection, callable $callback): Generator
{
    yield from curriedFlatMap($callback)($collection);
}
