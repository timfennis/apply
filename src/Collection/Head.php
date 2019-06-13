<?php

namespace Apply\Collection;

use Generator;
use InvalidArgumentException;

/**
 * head :: [a] -> a
 *
 * Extract the first element of a list, which must be non-empty.
 *
 * @param iterable $collection
 *
 * @throws InvalidArgumentException if the list is completely empty
 *
 * @return mixed
 */
function head(iterable $collection)
{
    foreach ($collection as $item) {
        return $item;
    }


    throw new InvalidArgumentException('Head cannot operate on an empty list');
}