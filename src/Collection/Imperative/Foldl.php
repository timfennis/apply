<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl as curriedFoldl;

/**
 * @param iterable $iterable
 * @param callable $callable
 *
 * @return mixed
 */
function foldl(iterable $iterable, callable $callable)
{
    return curriedFoldl($callable)($iterable);
}
