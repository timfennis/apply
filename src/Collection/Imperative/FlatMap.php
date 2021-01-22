<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\flatMap as curriedFlatMap;
use Generator;

/**
 * Flat map!
 *
 * @phpstan-template    A
 * @phpstan-template    B
 * @phpstan-param       iterable<A>                 $collection
 * @phpstan-param       callable(A): iterable<B>    $callback
 * @phpstan-return      Generator<B>
 */
function flatMap(iterable $collection, callable $callback): Generator
{
    yield from curriedFlatMap($callback)($collection);
}
