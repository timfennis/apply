<?php


namespace Apply\Collection;

use Generator;
use InvalidArgumentException;
use Traversable;

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
    } elseif ($iterable instanceof Traversable) {
        yield from array_reverse(iterator_to_array($iterable));
    } else {
        // @codeCoverageIgnoreStart
        // This should never really happen because something either has to be an array or \Traversable in order to be iterable
        throw new InvalidArgumentException('Cannot reverse invalid iterable');
        // @codeCoverageIgnoreEnd
    }
}
