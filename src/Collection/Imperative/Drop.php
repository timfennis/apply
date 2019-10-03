<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\drop as curriedDrop;
use Generator;

/**
 * @param iterable $iterable
 * @param int $amount
 *
 * @return Generator
 */
function drop(iterable $iterable, int $amount): Generator
{
    yield from curriedDrop($amount)($iterable);
}
