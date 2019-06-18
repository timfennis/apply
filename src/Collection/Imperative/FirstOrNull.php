<?php


namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\firstOrNull as curriedFirstOrNull;
use function Apply\constant;

/**
 * @param iterable $collection
 * @param callable $predicate
 *
 * @return mixed
 */
function firstOrNull(iterable $collection, ?callable $predicate = null)
{
    $predicate = $predicate ?? constant(true);
    return curriedFirstOrNull($predicate)($collection);
}
