<?php


namespace Apply\Collection\Curried;

/**
 * elem :: a -> [a] -> Bool
 *
 * @param mixed $item
 *
 * @return callable
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
