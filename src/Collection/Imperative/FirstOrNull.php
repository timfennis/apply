<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\firstOrNull as curriedFirstOrNull;
use function Apply\constant;

/**
 * @param iterable $collection Some list of T's
 * @param callable $predicate  A predicate that receives every item in the list and returns true or false
 *
 * @return mixed
 *
 * @phpstan-template T
 * @phpstan-param iterable<T>         $collection
 * @phpstan-param callable(T): bool    $predicate
 * @phpstan-return                    T|null
 */
function firstOrNull(iterable $collection, ?callable $predicate = null)
{
    $predicate = $predicate ?? constant(true);

    return curriedFirstOrNull($predicate)($collection);
}
