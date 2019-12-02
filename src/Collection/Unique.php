<?php

declare(strict_types=1);

namespace Apply\Collection;

use Generator;
use function in_array;

/**
 * unique :: [a] -> [a].
 */
function unique(iterable $collection): Generator
{
    $elementsSeen = [];
    foreach ($collection as $key => $element) {
        if (!in_array($element, $elementsSeen)) {
            $elementsSeen[] = $element;
            yield $element;
        }
    }
}
