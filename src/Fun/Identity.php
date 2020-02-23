<?php

declare(strict_types=1);

namespace Apply\Fun;

/**
 * @phpstan-template T
 * @phpstan-param T $a
 * @phpstan-return T
 *
 * @param mixed $a
 *
 * @return mixed
 */
function identity($a)
{
    return $a;
}
