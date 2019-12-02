<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl as curriedFoldl;

/**
 * @param mixed $initial
 *
 * @return mixed
 */
function foldl(iterable $iterable, callable $callable, $initial)
{
    return curriedFoldl($callable)($initial)($iterable);
}
