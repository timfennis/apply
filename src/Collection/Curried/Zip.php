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
            //@todo this default to null behavior is probably not compliant with every rule ever ??
            yield [$a, $bs[$index] ?? null];
        }
    };
}
