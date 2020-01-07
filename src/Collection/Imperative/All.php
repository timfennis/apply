<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\all as curriedAll;

/**
 * Checks whether some predicate is true for every element in the collection.
 *
 * @phpstan-template    T
 * @phpstan-param       iterable<T>           $iterable
 * @phpstan-param       callable(T): bool     $predicate
 * @phpstan-return      bool
 */
function all(iterable $iterable, callable $predicate): bool
{
    return curriedAll($predicate)($iterable);
}
