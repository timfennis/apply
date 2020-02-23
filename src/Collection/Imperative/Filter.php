<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\filter as curriedFilter;
use Generator;

/**
 * @phpstan-template    T
 * @phpstan-param       iterable<T>         $collection
 * @phpstan-param       callable(T): bool   $predicate
 * @phpstan-return      Generator<T>
 */
function filter(iterable $collection, callable $predicate): Generator
{
    yield from curriedFilter($predicate)($collection);
}
