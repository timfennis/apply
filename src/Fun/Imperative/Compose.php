<?php

declare(strict_types=1);

namespace Apply\Fun\Imperative;

function compose(callable $l, callable $r)
{
    return fn($arg) => $l($r($arg));
}