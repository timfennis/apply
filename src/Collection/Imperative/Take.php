<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\take as curriedTake;
use Generator;

function take(iterable $collection, int $amount): Generator
{
    yield from curriedTake($amount)($collection);
}
