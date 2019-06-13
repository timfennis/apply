<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl1 as curriedFoldl1;

function foldl1(iterable $iterable, callable $callable)
{
    return curriedFoldl1($callable)($iterable);
}
