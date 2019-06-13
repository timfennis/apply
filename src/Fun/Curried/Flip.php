<?php

namespace Apply\Fun\Curried;

/**
 * flip :: (a -> b -> c) -> b -> a -> c
 *
 * flip f takes its (first) two arguments in the reverse order of f.
 *
 * I actually have no idea if this has any practical usages in PHP
 *
 * @param callable $f
 *
 * @return callable
 */
function flip(callable $f): callable
{
    return static function ($a) use ($f) {
        return static function ($b) use ($f, $a) {
            return $f($b, $a);
        };
    };
}
