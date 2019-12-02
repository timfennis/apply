<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\zipWith as zipWithCurried;
use Generator;

/**
 * zipWith :: (a -> b -> c) -> [a] -> [b] -> [c].
 */
function zipWith(iterable $a, iterable $b, callable $zipper): Generator
{
    yield from zipWithCurried($zipper)($a)($b);
}
