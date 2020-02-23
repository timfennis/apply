<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\drop as curriedDrop;
use Generator;

/**
 * Drops `n` amount of elements from a collection and then returns the result.
 *
 * @phpstan-template    T
 * @phpstan-param       iterable<T>     $iterable
 * @phpstan-param       int             $amount
 * @phpstan-return      Generator<T>
 */
function drop(iterable $iterable, int $amount): Generator
{
    yield from curriedDrop($amount)($iterable);
}
