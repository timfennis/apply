<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\lastOrNull as lastOrNullCurried;

function lastOrNull(iterable $collection, callable $predicate)
{
    return lastOrNullCurried($predicate)($collection);
}
