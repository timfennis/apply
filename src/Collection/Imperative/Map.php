<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\map as curriedMap;
use Generator;

function map(iterable $collection, callable $callback): Generator
{
    yield from curriedMap($callback)($collection);
}
