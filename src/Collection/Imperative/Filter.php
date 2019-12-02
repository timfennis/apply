<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\filter as curriedFilter;
use Generator;

function filter(iterable $collection, callable $predicate): Generator
{
    yield from curriedFilter($predicate)($collection);
}
