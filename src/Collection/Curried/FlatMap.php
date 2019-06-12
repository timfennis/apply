<?php

namespace Apply\Collection\Curried;

use Generator;

/**
 * flatMap :: (a -> [b]) -> [a] -> [b]
 *
 * Functional curried version of flatMap comparable to >>= on lists in haskell
 *
 * @param callable $callable a -> [b]
 *
 * @return callable
 */
function flatMap(callable $callable): callable
{
    return static function (iterable $collection) use ($callable): Generator {
        foreach ($collection as $index => $value) {
            $result = $callable($value);

            if (is_iterable($result)) {
                yield from $result;
            }
        }
    };
}
