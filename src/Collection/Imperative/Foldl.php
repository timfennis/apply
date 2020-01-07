<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl as curriedFoldl;

/**
 * @param mixed $initial
 *
 * @return mixed
 *
 * @phpstan-template    T
 * @phpstan-param       iterable<T>         $iterable
 * @phpstan-param       callable(T,T): T    $callable
 * @phpstan-param       T                   $initial
 * @phpstan-return      T
 */
function foldl(iterable $iterable, callable $callable, $initial)
{
    return curriedFoldl($callable)($initial)($iterable);
}
