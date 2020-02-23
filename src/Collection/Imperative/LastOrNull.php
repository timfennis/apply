<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\lastOrNull as lastOrNullCurried;
use function Apply\Fun\constant;

/**
 * @phpstan-template    T
 * @phpstan-param       iterable<T>         $collection
 * @phpstan-param       callable(T): bool   $predicate
 * @phpstan-return      ?T
 */
function lastOrNull(iterable $collection, ?callable $predicate = null)
{
    $predicate = $predicate ?? constant(true);

    return lastOrNullCurried($predicate)($collection);
}
