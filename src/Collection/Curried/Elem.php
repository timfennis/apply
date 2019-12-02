<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

/**
 * elem :: a -> [a] -> Bool.
 *
 * @param mixed $item
 */
function elem($item): callable
{
    return static function (iterable $collection) use ($item): bool {
        foreach ($collection as $value) {
            if ($value === $item) {
                return true;
            }
        }

        return false;
    };
}
