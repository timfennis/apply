<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\foldl1 as curriedFoldl1;

/**
 * @phpstan-template    A
 * @phpstan-template    B
 * @phpstan-param       iterable<B>         $iterable
 * @phpstan-param       callable(A,B): A    $callable
 * @phpstan-return      A
 */
function foldl1(iterable $iterable, callable $callable)
{
    return curriedFoldl1($callable)($iterable);
}
