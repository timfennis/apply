<?php

namespace Apply\Collection;

use InvalidArgumentException;

/**
 * last :: [a] -> a
 *
 * @param iterable $collection
 *
 * @return mixed|null
 */
function last(iterable $collection)
{
    $match = null;
    $empty = true;

    foreach ($collection as $item) {
        $empty = false;
        $match = $item;
    }

    if ($empty === true) {
        throw new InvalidArgumentException('Head cannot operate on an empty list');
    }

    return $match;
}
