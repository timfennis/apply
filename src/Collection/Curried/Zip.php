<?php

namespace Apply\Collection\Curried;

use Generator;

/**
 * zip :: [a] -> [b] -> [(a, b)]
 *
 * @param iterable $as
 * @return callable
 */
function zip(iterable $as): callable
{
    return static function (iterable $bs) use ($as): Generator {
        foreach ($as as $index => $a) {
            yield [$a, $bs[$index]];
        }
    };
}
