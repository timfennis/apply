<?php

declare(strict_types=1);

namespace Apply;

use function Apply\Collection\Imperative\firstOrNull;
use function Apply\Option\just;
use Apply\Option\Option;

/** @var Option<int>[] $list */
$list = [just(5), just(4)];

$val = firstOrNull($list, fn (Option $f) => 4 == $f->getOrElse(20));
