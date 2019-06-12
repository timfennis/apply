<?php

namespace Apply\Collection\Curried;

/**
 * foldl1 :: (a -> a -> a) -> [a] -> a
 *
 * @param callable $callable
 *
 * @return callable
 */
function foldl1(callable $callable): callable
{
    return static function (iterable $iterable) use ($callable) {
        $acc = null;
        foreach ($iterable as $value) {
            if ($acc === null) {
                $acc = $value;
            } else {
                $acc = $callable($acc, $value);
            }
        }

        return $acc;
    };
}
