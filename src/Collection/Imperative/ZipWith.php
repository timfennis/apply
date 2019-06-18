<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\zipWith as zipWithCurried;
use Generator;

/**
 * zipWith :: (a -> b -> c) -> [a] -> [b] -> [c]
 *
 * @param iterable $a
 * @param iterable $b
 * @param callable $zipper
 *
 * @return Generator
 */
function zipWith(iterable $a, iterable $b, callable $zipper): Generator
{
    yield from zipWithCurried($zipper)($a)($b);
}
