<?php

declare(strict_types=1);

namespace Apply\Option;

/**
 * @param mixed $value
 */
function just($value): Option
{
    return Option::fromValue($value);
}
