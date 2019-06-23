<?php

namespace Apply;

/**
 * constant :: a -> (b -> a)
 *
 * constant x is a unary function which evaluates to x for all inputs
 *
 * @param mixed $a
 *
 * @return callable
 */
function constant($a): callable
{
    //todo do we keep $b?
    return static function ($b = null) use ($a) {
        return $a;
    };
}
