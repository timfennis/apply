<?php

declare(strict_types=1);

namespace Apply\Collection;

use Traversable;

/**
 * Shorter version of iterator_to_array with use_keys set to false.
 */
function toArray(Traversable $iterator): array
{
    return iterator_to_array($iterator, false);
}
