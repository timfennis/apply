<?php

declare(strict_types=1);

namespace Apply\Fun\Curried;

use Apply\Exception\InvalidArgumentException;

function operator(string $symbol)
{
    switch ($symbol) {
        case 'instanceof':
            return static function ($a) {
                return static fn ($b) => $a instanceof $b;
            };
        case '*':
            return static function ($a) {
                return static fn ($b) => $a * $b;
            };
        case '/':
            return static function ($a) {
                return static fn ($b) => $a / $b;
            };
        case '%':
            return static function ($a) {
                return static fn ($b) => $a % $b;
            };
        case '+':
            return static function ($a) {
                return static fn ($b) => $a + $b;
            };
        case '-':
            return static function ($a) {
                return static fn ($b) => $a - $b;
            };
        case '.':
            return static function ($a) {
                return static fn ($b) => $a.$b;
            };
        case '<<':
            return static function ($a) {
                return static fn ($b) => $a << $b;
            };
        case '>>':
            return static function ($a) {
                return static fn ($b) => $a >> $b;
            };
        case '<':
            return static function ($a) {
                return static fn ($b) => $a < $b;
            };
        case '<=':
            return static function ($a) {
                return static fn ($b) => $a <= $b;
            };
        case '>':
            return static function ($a) {
                return static fn ($b) => $a > $b;
            };
        case '>=':
            return static function ($a) {
                return static fn ($b) => $a >= $b;
            };
        case '==':
            return static function ($a) {
                return static fn ($b) => $a == $b;
            };
        case '!=':
            return static function ($a) {
                return static fn ($b) => $a != $b;
            };
        case '===':
            return static function ($a) {
                return static function ($b) use ($a) {
                    return $a === $b;
                };
            };
        case '!==':
            return static function ($a) {
                return static fn ($b) => $a !== $b;
            };
        case '&':
            return static function ($a) {
                return static fn ($b) => $a & $b;
            };
        case '^':
            return static function ($a) {
                return static fn ($b) => $a ^ $b;
            };
        case '|':
            return static function ($a) {
                return static fn ($b) => $a | $b;
            };
        case '&&':
            return static function ($a) {
                return static fn ($b) => $a && $b;
            };
        case '||':
            return static function ($a) {
                return static fn ($b) => $a || $b;
            };
        case '**':
            return static function ($a) {
                return static fn ($b) => $a ** $b;
            };
        case '<=>':
            return static function ($a) {
                return static fn ($b) => $a <=> $b;
            };
        default:
            throw new InvalidArgumentException("Unknown operator '$symbol'");
    }
}
