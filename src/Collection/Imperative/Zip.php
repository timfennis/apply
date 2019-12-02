<?php

declare(strict_types=1);

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\zip as zipCurried;
use Generator;

function zip(iterable $a, iterable $b): Generator
{
    yield from zipCurried($a)($b);
}
