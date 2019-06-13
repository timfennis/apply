<?php

namespace Apply\Fun\Curried;

use Apply\Exception\InvalidArgumentException;

function operator(string $symbol)
{
    switch ($symbol) {
        case 'instanceof':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a instanceof $b;
                };
            };
        case '*':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a * $b;
                };
            };
        case '/':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a / $b;
                };
            };
        case '%':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a % $b;
                };
            };
        case '+':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a + $b;
                };
            };
        case '-':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a - $b;
                };
            };
        case '.':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a . $b;
                };
            };
        case '<<':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a << $b;
                };
            };
        case '>>':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a >> $b;
                };
            };
        case '<':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a < $b;
                };
            };
        case '<=':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a <= $b;
                };
            };
        case '>':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a > $b;
                };
            };
        case '>=':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a >= $b;
                };
            };
        case '==':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a == $b;
                };
            };
        case '!=':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a != $b;
                };
            };
        case '===':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a === $b;
                };
            };
        case '!==':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a !== $b;
                };
            };
        case '&':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a & $b;
                };
            };
        case '^':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a ^ $b;
                };
            };
        case '|':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a | $b;
                };
            };
        case '&&':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a && $b;
                };
            };
        case '||':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a || $b;
                };
            };
        case '**':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a ** $b;
                };
            };
        case '<=>':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a <=> $b;

                };
            };
        default :
            throw new InvalidArgumentException("Unknown operator '$symbol'");
    }
}
