<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

/**
 * @param iterable $collection collection of items to sort
 * @param callable $f          function that takes an item from $collection and returns a valid value for the <=> operator
 */
function sortOn(iterable $collection, callable $f): iterable
{
    return \Apply\Collection\Curried\sortOn($f)($collection);
}
