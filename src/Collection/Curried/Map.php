<?php

namespace Apply\Collection\Curried;

use Generator;

/**
 * map :: (a -> b) -> [a] -> [b]
 *
 * map f xs is the list obtained by applying f to each element of xs, i.e.,
 *
 * @param callable $f a -> b
 *
 * @return callable
 */
function map(callable $f): callable
{
    return static function (iterable $collection) use ($f): Generator {
        foreach ($collection as $value) {
            yield $f($value);
        }
    };
}
