<?php

declare(strict_types=1);

namespace Apply\Collection;

use Generator;
use InvalidArgumentException;

/**
 * tail :: [a] -> [a].
 *
 * Extract the elements after the head of a list, which must be non-empty.
 *
 * @throws InvalidArgumentException if the list is completely empty
 */
function tail(iterable $collection): Generator
{
    $first = true;
    foreach ($collection as $item) {
        if (true === $first) {
            $first = false;
            continue;
        }

        yield $item;
    }

    if (true === $first) {
        throw new InvalidArgumentException('Tail cannot operate on an empty list');
    }
}
