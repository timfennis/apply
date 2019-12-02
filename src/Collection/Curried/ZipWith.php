<?php

declare(strict_types=1);

namespace Apply\Collection\Curried;

use ArrayIterator;
use Generator;
use Iterator;
use MultipleIterator;

/**
 * zipWith :: (a -> b -> c) -> [a] -> [b] -> [c].
 */
function zipWith(callable $zipper): callable
{
    return static function ($as) use ($zipper): callable {
        return static function (iterable $bs) use ($zipper, $as): Generator {
            $i = new MultipleIterator();
            $i->attachIterator($as instanceof Iterator ? $as : new ArrayIterator($as));
            $i->attachIterator($bs instanceof Iterator ? $bs : new ArrayIterator($bs));
            foreach ($i as $values) {
                yield $zipper(...$values);
            }
        };
    };
}
