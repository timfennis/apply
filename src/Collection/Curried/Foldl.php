<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

/**
 * foldl :: (b -> a -> b) -> b -> [a] -> b.
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
