<?php

namespace Phunctional\Collection\Curried;

use Generator;

function flatMap(iterable $collection): callable
{
    return static function (callable $callable) use ($collection): Generator {
        foreach ($collection as $index => $value) {
            $result = $callable($value);

            if (is_iterable($result)) {
                yield from $result;
            } else {
                yield $result;
            }
        }
    };
}
