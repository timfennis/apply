<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\cons as curriedCons;
use Generator;

/**
 * Lazily prepends some collection with a single element.
 *
 * @param mixed $head
 *
 * @phpstan-template    T
 * @phpstan-param       T               $head
 * @phpstan-param       iterable<T>     $tail
 * @phpstan-return      iterable<T>
 */
function cons($head, iterable $tail): Generator
{
    yield from curriedCons($head)($tail);
}
