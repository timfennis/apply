<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl as curriedFoldl;

/**
 * @param mixed $initial
 *
 * @return mixed
 *
 * @phpstan-template    A
 * @phpstan-template    B
 * @phpstan-param       iterable<B>         $iterable
 * @phpstan-param       callable(A,B): A    $callable
 * @phpstan-param       A                   $initial
 * @phpstan-return      A
 */
function foldl(iterable $iterable, callable $callable, $initial)
{
    return curriedFoldl($callable)($initial)($iterable);
}
