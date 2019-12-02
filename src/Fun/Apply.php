<?php

declare(strict_types=1);

namespace Apply\Fun;

/**
 * @param mixed ...$arguments
 */
function apply(callable $callable, ...$arguments): callable
{
    return static fn (...$moreArguments) => $callable(...$arguments, ...$moreArguments);
}
