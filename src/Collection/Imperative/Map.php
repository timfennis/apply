<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\map as curriedMap;
use Generator;

/**
 * @phpstan-template    T
 * @phpstan-template    R
 * @phpstan-param       iterable<T>     $collection
 * @phpstan-param       callable(T): R  $callback
 * @phpstan-return      iterable<R>
 */
function map(iterable $collection, callable $callback): Generator
{
    yield from curriedMap($callback)($collection);
}
