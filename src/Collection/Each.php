<?php

namespace Apply\Collection;

/**
 * Apply a callable to every item in a collection (not lazy) in order to provide a function al foreach.
 *
 * This function is digusting because you'd only use it for side effects :-(
 *
 * @param iterable $collection
 * @param callable $function
 */
function each(iterable $collection, callable $function)
{
    foreach ($collection as $value) {
        $function($value);
    }
}