<?php

declare(strict_types=1);

namespace Apply\Option;

use function Apply\Fun\constant;

function optionToList(Option $option)
{
    return $option->fold(constant([]), '\Apply\Option\just');
}
