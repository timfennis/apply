<?php

declare(strict_types=1);

namespace Apply;

/**
 * constant :: a -> (b -> a).
 *
 * constant x is a unary function which evaluates to x for all inputs
 *
 * @param mixed $a
 */
function constant($a): callable
{
    //todo do we keep $b?
    return static fn ($b = null) => $a;
}
