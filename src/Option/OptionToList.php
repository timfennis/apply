<?php

namespace Apply\Option;

use function Apply\constant;

function optionToList(Option $option)
{
    return $option->fold(constant([]), '\Apply\Option\just');
}
