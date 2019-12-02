<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\drop as curriedDrop;
use Generator;

function drop(iterable $iterable, int $amount): Generator
{
    yield from curriedDrop($amount)($iterable);
}
