<?php

namespace Apply\Collection;

use Iterator;

/**
 * Shorter version of iterator_to_array with use_keys set to false
 *
 * @param Iterator $iterator
 * @return array
 */
function toArray(Iterator $iterator): array
{
    return iterator_to_array($iterator, false);
}
