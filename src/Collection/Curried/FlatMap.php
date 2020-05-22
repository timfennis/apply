<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

use Generator;

/**
 * flatMap :: (a -> [b]) -> [a] -> [b].
 *
 * Functional curried version of flatMap comparable to >>= on lists in haskell
 *
 * @param callable $callable a -> [b]
 */
function flatMap(callable $callable): callable
{
    return static function (iterable $collection) use ($callable): Generator {
        foreach ($collection as $value) {
            foreach ($callable($value) as $innerValue) {
                yield $innerValue;
            }
        }
    };
}
