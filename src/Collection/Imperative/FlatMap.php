<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\flatMap as curriedFlatMap;
use Generator;

function flatMap(iterable $collection, callable $callback): Generator
{
    yield from curriedFlatMap($callback)($collection);
}
