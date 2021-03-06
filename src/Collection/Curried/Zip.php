<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

use ArrayIterator;
use Generator;
use Iterator;
use MultipleIterator;

/**
 * zip :: [a] -> [b] -> [(a, b)].
 */
function zip(iterable $as): callable
{
    return static function (iterable $bs) use ($as): Generator {
        $i = new MultipleIterator();
        $i->attachIterator($as instanceof Iterator ? $as : new ArrayIterator($as));
        $i->attachIterator($bs instanceof Iterator ? $bs : new ArrayIterator($bs));
        foreach ($i as $values) {
            yield $values;
        }
    };
}
