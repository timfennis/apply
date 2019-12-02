<?php

declare(strict_types=1);

namespace Apply\Collection;

use function Apply\Collection\Imperative\foldl1;

function maximum(iterable $collection)
{
    return foldl1($collection, static fn ($a, $b) => max($a, $b));
}
