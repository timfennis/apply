<?php

declare(strict_types=1);

namespace Apply\Collection;

use Apply\Exception\InvalidArgumentException;

/**
 * last :: [a] -> a.
 */
function last(iterable $collection): mixed
{
    if (is_array($collection)) {
        $key = array_key_last($collection);
        if (null !== $key) {
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

        if (true === $empty) {
            throw new InvalidArgumentException('Last cannot operate on an empty list');
        }

        return $match;
    }
}
