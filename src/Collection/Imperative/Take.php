<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\take as curriedTake;
use Generator;

/**
 * @param iterable $collection
 * @param int $amount
 *
 * @return Generator
 */
function take(iterable $collection, int $amount): Generator
{
    yield from curriedTake($amount)($collection);
}
