<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl1 as curriedFoldl1;

/**
 * @phpstan-template    T
 * @phpstan-param       iterable<T>         $iterable
 * @phpstan-param       callable(T,T): T    $callable
 * @phpstan-return      T
 */
function foldl1(iterable $iterable, callable $callable)
{
    return curriedFoldl1($callable)($iterable);
}
