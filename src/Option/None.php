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

use EmptyIterator;
use Exception;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

final class None extends Option
{
    private static ?None $instance = null;

    private function __construct()
    {
    }

    public static function create(): None
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    #[Pure]
    public function getIterator(): EmptyIterator
    {
        return new EmptyIterator();
    }

    public function get()
    {
        throw new RuntimeException(self::class.' has no value.');
    }

    public function getOrCall(callable $callable)
    {
        return $callable();
    }

    public function getOrElse($default)
    {
        return $default;
    }

    public function getOrThrow(Exception $ex)
    {
        throw $ex;
    }

    public function isEmpty(): bool
    {
        return true;
    }

    public function isDefined(): bool
    {
        return false;
    }

    public function orElse(Option $else): Option
    {
        return $else;
    }

    public function forAll(callable $callable): Option
    {
        return $this;
    }

    public function map(callable $callable): Option
    {
        return $this;
    }

    public function flatMap(callable $callable): Option
    {
        return $this;
    }

    public function filter(callable $callable): Option
    {
        return $this;
    }

    public function filterNot(callable $callable): Option
    {
        return $this;
    }

    public function select($value): Option
    {
        return $this;
    }

    public function reject($value): Option
    {
        return $this;
    }

    public function foldLeft($initialValue, $callable)
    {
        return $initialValue;
    }

    public function foldRight($initialValue, $callable)
    {
        return $initialValue;
    }

    public function fold(callable $ifEmpty, callable $ifSome)
    {
        return $ifEmpty();
    }

    public function orNull()
    {
        return null;
    }
}
