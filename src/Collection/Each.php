<?php

declare(strict_types=1);

namespace Apply\Collection;

/**
 * Apply a callable to every item in a collection (not lazy) in order to provide a function al foreach.
 *
 * This function is disgusting because you'd only use it for side effects :-(
 *
 * @deprecated don't use this you sick fuck
 */
function each(iterable $collection, callable $function)
{
    foreach ($collection as $value) {
        $function($value);
    }
}
