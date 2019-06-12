<?php

namespace Apply\Collection\Curried;

use Closure;
use Generator;

/**
 * take :: Int -> [a] -> [a]
 *
 * take n, applied to a list xs, returns the prefix of xs of length n, or xs itself if n > length xs:
 *
 * @param int $amount
 *
 * @return callable
 */
function take(int $amount): callable
{
    return static function (iterable $collection) use ($amount): Generator {
        foreach ($collection as $key => $value) {
            if ($amount-- === 0) {
                return;
            }

            yield $key => $value;
        }
    };
}
