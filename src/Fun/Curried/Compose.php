<?php

declare(strict_types=1);

namespace Apply\Fun\Curried;


function compose(callable $lft): callable
{
    return static fn($rgt) => static fn ($arg) => $lft($rgt($arg));
}