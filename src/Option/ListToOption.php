<?php


namespace Apply\Option;

function listToOption(iterable $iterable)
{
    foreach ($iterable as $item) {
        return Some::fromValue($item);
    }

    return None::create();
}
