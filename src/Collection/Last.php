<?php

namespace Apply\Collection;

use Apply\Exception\InvalidArgumentException;

/**
 * last :: [a] -> a
 *
 * @param iterable $collection
 *
 * @return mixed|null
 */
function last(iterable $collection)
{
    if (is_array($collection)) {
        $key = array_key_last($collection);
        if ($key !== null) {
            return $collection[$key];
        } else {
            throw new InvalidArgumentException('Last cannot operate on an empty list');
        }
    } else {

        $match = null;
        $empty = true;

        foreach ($collection as $item) {
            $empty = false;
            $match = $item;
        }

        if ($empty === true) {
            throw new InvalidArgumentException('Last cannot operate on an empty list');
        }

        return $match;
    }
}
