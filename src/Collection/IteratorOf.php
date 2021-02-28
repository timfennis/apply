<?php

declare(strict_types=1);

namespace Apply\Collection;

use Generator;

/**
 * Converts some iterable into a Generator by calling yield from.
 */
function iteratorOf(iterable $iterable): Generator
{
    yield from $iterable;
}
