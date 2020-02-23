<?php

declare(strict_types=1);

namespace Apply\Fun\Imperative;

use function Apply\Collection\Imperative\foldl1;

function pipe($a, $b): callable
{
    return static fn (...$args) => $b($a(...$args));
}

function pipeMany(...$operations): callable
{
    return static function (...$arguments) use ($operations) {
        return foldl1($operations, 'Apply\Fun\Imperative\pipe')(...$arguments);
    };
}
