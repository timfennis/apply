<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\any as curriedAny;

/**
 * Checks whether some predicate is true for any elements in a collection.
 *
 * In some libraries this function may be called `some`
 *
 * @phpstan-template    T
 * @phpstan-param       iterable<T>           $iterable
 * @phpstan-param       callable(T): bool     $predicate
 * @phpstan-return      bool
 */
function any(iterable $iterable, callable $predicate): bool
{
    return curriedAny($predicate)($iterable);
}
