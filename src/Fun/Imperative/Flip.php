<?php

namespace Apply\Fun\Imperative;

/**
 * flip f takes its (first) two arguments in the reverse order of f.
 *
 * This version accepts an uncurried function with two arguments and flips them.
 *
 * @param callable $f
 *
 * @return callable
 */
function flip(callable $f): callable
{
    return static function ($a, $b) use ($f) {
        return $f($b, $a);
    };
}
