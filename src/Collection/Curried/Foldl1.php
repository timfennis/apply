<?php

namespace Apply\Collection\Curried;

use Apply\Exception\InvalidArgumentException;

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
        $notEmpty = false;
        foreach ($iterable as $value) {
            $notEmpty = true;
            if ($acc === null) {
                $acc = $value;
            } else {
                $acc = $callable($acc, $value);
            }
        }

        if ($notEmpty === false) {
            throw new InvalidArgumentException('foldl1 does not work on empty lists');
        }

        return $acc;
    };
}
