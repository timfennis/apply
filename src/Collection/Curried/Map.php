<?php

namespace Apply\Collection\Curried;

use Generator;

/**
 * map :: (a -> b) -> [a] -> [b]
 *
 * @param callable $callable
 *
 * @return callable
 */
function map(callable $callable): callable
{
    return static function (iterable $iterable) use ($callable): Generator {
        foreach ($iterable as $item) {
            yield $callable($item);
        }
    };
}
