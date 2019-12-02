<?php

declare(strict_types=1);

/*
 * This code is derived from schmittjoh/php-option
 *
 * PHP Option license follows:
 *
 * Copyright 2012 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Apply\Option;

use Exception;
use Generator;
use IteratorAggregate;

/**
 * Class Option.
 *
 * @template T
 */
abstract class Option implements IteratorAggregate
{
    public static function fromValue($value, $noneValue = null): Option
    {
        if ($value === $noneValue) {
            return None::create();
        }

        return new Some($value);
    }

    public static function fromArraysValue($array, $key): Option
    {
        if (!isset($array[$key])) {
            return None::create();
        }

        return new Some($array[$key]);
    }

    abstract public function orNull();

    abstract public function get();

    abstract public function getOrElse($default);

    abstract public function getOrCall(callable $callable);

    abstract public function getOrThrow(Exception $ex);

    abstract public function isEmpty(): bool;

    abstract public function isDefined(): bool;

    abstract public function orElse(Option $else): Option;

    abstract public function forAll(callable $callable): Option;

    abstract public function map(callable $callable): Option;

    abstract public function flatMap(callable $callable): Option;

    abstract public function filter(callable $callable): Option;

    abstract public function filterNot(callable $callable): Option;

    abstract public function select($value): Option;

    abstract public function reject($value): Option;

    abstract public function foldLeft($initialValue, callable $callable);

    abstract public function foldRight($initialValue, callable $callable);

    abstract public function fold(callable $ifEmpty, callable $ifSome);

    /**
     * @template A
     * @phan-param callable(): Option<A> $callable
     * @phan-return Option<A>
     */
    public static function binding(callable $callable): Option
    {
        /** @var Generator $generator */
        $generator = $callable();

        /** @var Option $current */
        $current = $generator->current();

        do {
            if ($current instanceof Some) {
                $current = $generator->send($current->get());
            }

            if ($current instanceof None) {
                return $current;
            }
        } while ($generator->valid());

        return Option::fromValue($generator->getReturn());
    }
}
