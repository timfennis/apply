<?php

namespace Apply\Collection\Curried;

use Generator;

/**
 * zipWith :: (a -> b -> c) -> [a] -> [b] -> [c]
 *
 * @param callable $zipper
 *
 * @return callable
 */
function zipWith(callable $zipper): callable
{
    return static function ($as) use ($zipper): callable {
        return static function (iterable $bs) use ($zipper, $as): Generator {
            foreach ($as as $index => $a) {
                yield $zipper($a, $bs[$index]);
            }
        };
    };
}