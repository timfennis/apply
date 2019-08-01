<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\cons as curriedCons;
use Generator;

/**
 * @param mixed $head
 * @param iterable $tail
 *
 * @return Generator
 */
function cons($head, iterable $tail): Generator
{
    yield from curriedCons($head)($tail);
}
