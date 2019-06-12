<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\map as curriedMap;
use Generator;

function map(iterable $iterable, callable $callable): Generator
{
    yield from curriedMap($callable)($iterable);
}
