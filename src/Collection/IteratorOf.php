<?php

namespace Apply\Collection;

use Generator;

/**
 * Converts some iterable into a Generator by calling yield from
 *
 * @param iterable $iterable
 *
 * @return Generator
 */
function iteratorOf(iterable $iterable)
{
    yield from $iterable;
}
