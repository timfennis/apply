<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\any as curriedAny;

function any(iterable $iterable, callable $callable): bool
{
    return curriedAny($callable)($iterable);
}
