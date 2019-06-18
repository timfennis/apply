<?php

namespace Apply\Collection\Curried;

/**
 * lastOrNull :: (a -> Bool) -> [a] -> ?a
 *
 * @param callable $predicate
 * @return callable
 */
function lastOrNull(callable $predicate): callable
{
    return static function (iterable $collection) use ($predicate) {
        $match = null;
        foreach ($collection as $index => $element) {
            if ($predicate($element, $index, $collection)) {
                $match = $element;
            }
        }

        return $match;
    };
}
