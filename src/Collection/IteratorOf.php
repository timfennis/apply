<?php

declare(strict_types=1);

namespace Apply\Collection;

use Generator;

/**
 * Converts some iterable into a Generator by calling yield from.
 *
 * @return Generator
 */
function iteratorOf(iterable $iterable)
{
    yield from $iterable;
}
