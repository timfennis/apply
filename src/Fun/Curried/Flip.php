<?php

namespace Apply\Fun\Curried;

/**
 * flip :: (a -> b -> c) -> b -> a -> c
 *
 * flip f takes its (first) two arguments in the reverse order of f.
 *
 * This version flips the arguments of a curried function and returns a flipped curried function.
 *
 * @param callable $f
 *
 * @return callable
 */
function flip(callable $f): callable
{
    return static function ($a) use ($f) {
        return static function ($b) use ($f, $a) {
            return $f($b)($a);
        };
    };
}
