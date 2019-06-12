<?php

namespace Apply\Collection\Curried;

/**
 * foldl :: (b -> a -> b) -> b -> [a] -> b
 *
 * @param callable $callable
 *
 * @return callable
 */
function foldl(callable $callable): callable
{
    return static function ($initial) use ($callable): callable {
        return static function (iterable $iterable) use ($callable, $initial) {
            $acc = $initial;
            foreach ($iterable as $value) {
                $acc = $callable($acc, $value);
            }

            return $acc;
        };
    };
}
