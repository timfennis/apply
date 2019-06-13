<?php

namespace Apply\Collection;

use InvalidArgumentException;

/**
 * tail :: [a] -> [a]
 *
 * Extract the elements after the head of a list, which must be non-empty.
 *
 * @param iterable $collection
 *
 * @throws InvalidArgumentException if the list is completely empty
 *
 * @return mixed
 */
function tail(iterable $collection)
{
    $first = true;
    foreach ($collection as $item) {
        if ($first === true) {
            $first = false;
            continue;
        }

        yield $item;
    }

    if ($first === true) {
        throw new InvalidArgumentException('Tail cannot operate on an empty list');
    }
}