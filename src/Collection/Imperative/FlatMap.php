<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\flatMap as curriedFlatMap;
use Generator;

/**
 * Flat map!
 *
 * @phpstan-template    T
 * @phpstan-param       iterable<T>                 $collection
 * @phpstan-param       callable(T): iterable<T>    $callback
 * @phpstan-return      Generator<T>
 */
function flatMap(iterable $collection, callable $callback): Generator
{
    yield from curriedFlatMap($callback)($collection);
}
