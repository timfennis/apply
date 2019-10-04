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
        //@todo a faster implementation for array is probably possible by iterating through the array in reverse
        if (is_array($collection)) {
            end($collection);
            do {
                if ($predicate(current($collection), key($collection), $collection)) {
                    return current($collection);
                }
            } while (prev($collection) !== false);

            return null;
        } else {
            $match = null;
            foreach ($collection as $index => $element) {
                if ($predicate($element, $index, $collection)) {
                    $match = $element;
                }
            }

            return $match;
        }
    };
}
