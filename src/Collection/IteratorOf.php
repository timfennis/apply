<?php

namespace Apply\Collection;

function iteratorOf(iterable $iterable)
{
    yield from $iterable;
}
