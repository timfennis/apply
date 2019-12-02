<?php

declare(strict_types=1);

namespace Apply\Fun\Curried;

/**
 * flip :: (a -> b -> c) -> b -> a -> c.
 *
 * flip f takes its (first) two arguments in the reverse order of f.
 *
 * This version flips the arguments of a curried function and returns a flipped curried function.
 */
function flip(callable $f): callable
{
    return static function ($a) use ($f) {
        return static fn ($b) => $f($b)($a);
    };
}
