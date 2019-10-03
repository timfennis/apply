<?php

namespace Apply\Collection\Curried;

use Generator;

/**
 * drop :: Int -> [a] -> [a]
 *
 * drop n xs returns the suffix of xs after the first n elements, or [] if n > length:
 *
 * @param int $amount
 *
 * @return callable
 */
function drop(int $amount): callable
{
    return static function (iterable $collection) use ($amount): Generator {
        foreach ($collection as $key => $value) {
            if ($amount-- > 0) {
                continue;
            }

            yield $key => $value;
        }
    };
}
