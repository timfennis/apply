<?php

declare(strict_types=1);

namespace Apply\Fun\Imperative;

/**
 * flip f takes its (first) two arguments in the reverse order of f.
 *
 * This version accepts an uncurried function with two arguments and flips them.
 */
function flip(callable $f): callable
{
    return static fn ($a, $b) => $f($b, $a);
}
