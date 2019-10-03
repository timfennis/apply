<?php

namespace Apply\Collection;

use function Apply\Collection\Imperative\foldl1;

function maximum(iterable $collection)
{
    return foldl1($collection, static function ($a, $b) {
        return max($a, $b);
    });
}
