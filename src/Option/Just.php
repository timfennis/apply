<?php

namespace Apply\Option;

/**
 * @param mixed $value
 *
 * @return Option
 */
function just($value): Option
{
    return Option::fromValue($value);
}
