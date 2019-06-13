<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl as curriedFoldl;

/**
 * @param iterable $iterable
 * @param mixed $initial
 * @param callable $callable
 *
 * @return mixed
 */
function foldl(iterable $iterable, callable $callable, $initial)
{
    return curriedFoldl($callable)($initial)($iterable);
}
