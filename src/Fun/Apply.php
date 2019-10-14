<?php

namespace Apply\Fun;

/**
 * @param callable $callable
 * @param mixed ...$arguments
 *
 * @return callable
 */
function apply(callable $callable, ...$arguments): callable
{
    return static function (...$moreArguments) use ($callable, $arguments) {
        return $callable(...array_merge($arguments, $moreArguments));
    };
}
