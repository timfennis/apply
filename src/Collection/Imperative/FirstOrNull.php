<?php


namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\firstOrNull as curriedFirstOrNull;
use function Apply\constant;

/**
 * @param iterable $collection
 * @param callable $predicate
 *
 * @return callable
 */
function firstOrNull(iterable $collection, ?callable $predicate = null): callable
{
    $predicate = $predicate ?? constant(true);
    return curriedFirstOrNull($predicate)($collection);
}