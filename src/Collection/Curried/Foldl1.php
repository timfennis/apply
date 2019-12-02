<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

use Apply\Exception\InvalidArgumentException;

/**
 * foldl1 :: (a -> a -> a) -> [a] -> a.
 */
function foldl1(callable $callable): callable
{
    return static function (iterable $iterable) use ($callable) {
        $acc = null;
        $notEmpty = false;
        foreach ($iterable as $value) {
            $notEmpty = true;
            if (null === $acc) {
                $acc = $value;
            } else {
                $acc = $callable($acc, $value);
            }
        }

        if (false === $notEmpty) {
            throw new InvalidArgumentException('foldl1 does not work on empty lists');
        }

        return $acc;
    };
}
