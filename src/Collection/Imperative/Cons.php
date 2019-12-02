<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\cons as curriedCons;
use Generator;

/**
 * @param mixed $head
 */
function cons($head, iterable $tail): Generator
{
    yield from curriedCons($head)($tail);
}
