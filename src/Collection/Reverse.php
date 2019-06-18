<?php


namespace Apply\Collection;

use Generator;
use InvalidArgumentException;

/**
 * reverse :: [a] -> [a]
 *
 * @param iterable $iterable
 *
 * @return Generator
 */
function reverse(iterable $iterable): Generator
{
    if (is_array($iterable)) {
        for (end($iterable); key($iterable) !== null; prev($iterable)) {
            yield current($iterable);
        }
    } elseif ($iterable instanceof \Traversable) {
        yield from array_reverse(iterator_to_array($iterable));
    } else {
        throw new InvalidArgumentException('Cannot reverse invalid iterable');
    }
}
