<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

use Generator;

/**
 * cons :: a -> [a] -> [a].
 *
 * @param mixed $head
 */
function cons($head): callable
{
    return static function (iterable $tail) use ($head): Generator {
        yield $head;
        yield from $tail;
    };
}
