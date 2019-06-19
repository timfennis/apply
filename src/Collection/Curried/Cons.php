<?php

namespace Apply\Collection\Curried;

use Generator;

/**
 * cons :: a -> [a] -> [a]
 *
 * @param mixed $head
 *
 * @return callable
 */
function cons($head): callable
{
    return static function (iterable $tail) use ($head) : Generator
    {
        yield $head;
        yield from $tail;
    };
}