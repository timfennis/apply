<?php

namespace Apply\Collection\Imperative;

use function Apply\Collection\Curried\zip as zipCurried;
use Generator;

/**
 * @param iterable $a
 * @param iterable $b
 *
 * @return Generator
 */
function zip(iterable $a, iterable $b): Generator
{
    yield from zipCurried($a)($b);
}
