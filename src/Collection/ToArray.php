<?php

namespace Apply\Collection;

use Traversable;

/**
 * Shorter version of iterator_to_array with use_keys set to false
 *
 * @param Traversable $iterator
 * @return array
 */
function toArray(Traversable $iterator): array
{
    return iterator_to_array($iterator, false);
}
