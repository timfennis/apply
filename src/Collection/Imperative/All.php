<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\all as curriedAll;

function all(iterable $iterable, callable $callable): bool
{
    return curriedAll($callable)($iterable);
}