<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

/**
 * @param iterable $collection collection of items to sort
 * @param callable $f          function that takes an item from $collection and returns a valid value for the <=> operator
 *
 * @phpstan-template T
 * @phpstan-param iterable<T> $collection
 * @phpstan-param callable(T,T):int $comparator
 * @phpstan-return iterable<T>
 */
function sortOn(iterable $collection, callable $comparator): iterable
{
    return \Apply\Collection\Curried\sortOn($comparator)($collection);
}
