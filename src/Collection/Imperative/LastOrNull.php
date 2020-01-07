<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\lastOrNull as lastOrNullCurried;

/**
 * @phpstan-template    T
 * @phpstan-param       iterable<T>         $collection
 * @phpstan-param       callable(T): bool   $predicate
 * @phpstan-return      ?T
 */
function lastOrNull(iterable $collection, callable $predicate)
{
    return lastOrNullCurried($predicate)($collection);
}
