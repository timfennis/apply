<?php

declare(strict_types=1);

namespace Apply\Collection;

/**
 * sort :: [a] -> [a].
 */
function sort(iterable $collection): iterable
{
    return Curried\sortBy(static fn ($left, $right) => $left <=> $right)($collection);
}
