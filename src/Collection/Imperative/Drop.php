<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\drop as curriedDrop;
use Generator;

/**
 * @param iterable $iterable
 * @param int $item
 *
 * @return Generator
 */
function drop(iterable $iterable, int $item): Generator
{
    yield from curriedDrop($item)($iterable);
}
