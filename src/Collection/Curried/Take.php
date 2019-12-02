<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

use Generator;

/**
 * take :: Int -> [a] -> [a].
 *
 * take n, applied to a list xs, returns the prefix of xs of length n, or xs itself if n > length xs:
 */
function take(int $amount): callable
{
    return static function (iterable $collection) use ($amount): Generator {
        foreach ($collection as $key => $value) {
            if (0 === $amount--) {
                return;
            }

            yield $key => $value;
        }
    };
}
