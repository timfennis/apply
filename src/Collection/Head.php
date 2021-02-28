<?php

declare(strict_types=1);

namespace Apply\Collection;

use InvalidArgumentException;

/**
 * head :: [a] -> a.
 *
 * Extract the first element of a list, which must be non-empty. use firstOrNull if you want to accept empty lists.
 *
 * @throws InvalidArgumentException if the list is completely empty
 *
 * @return mixed
 */
function head(iterable $collection): mixed
{
    foreach ($collection as $item) {
        return $item;
    }

    throw new InvalidArgumentException('Head cannot operate on an empty list');
}
