<?php

declare(strict_types=1);

namespace Apply\Option;

function just(mixed $value): Option
{
    return Option::fromValue($value);
}
