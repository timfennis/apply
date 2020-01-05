<?php

declare(strict_types=1);

namespace Apply;

use Apply\Option\Option;
use function Apply\Collection\Imperative\firstOrNull;
use function Apply\Option\just;


/** @var Option<int>[] $list */
$list = [just(5), just(4)];

$val = firstOrNull($list, fn (Option $f) => $f->getOrElse(20) == 4);

