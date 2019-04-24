<?php

namespace Phunctional\Collection;

use Generator;

function flatMap(iterable $collection, callable $callback): Generator
{
    yield from \Phunctional\Collection\Curried\flatMap($collection)($callback);
}
