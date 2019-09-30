<?php

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
use Apply\Collection\LazyIterator;
use Apply\Exception\InvalidStateException;

final class LazyOption extends Option
{
    /** @var callable */
    private $callback;

    /** @var array */
    private $arguments;

    /** @var Option|null */
    private $option;

    public static function create($callback, array $arguments = array())
    {
        return new self($callback, $arguments);
    }

    public function __construct(callable $callback, array $arguments = [])
    {
        $this->callback = $callback;
        $this->arguments = $arguments;
    }

    public function getIterator()
    {
        return new LazyIterator(function () {
            return $this->option()->getIterator();
        });
    }

    private function option(): Option
    {
        if ($this->option === null) {
            $option = ($this->callback)(...$this->arguments);

            if (false === $option instanceof Option) {
                throw InvalidStateException::invalidCallableReturnType(Option::class, gettype($option));
            }

            $this->option = $option;
        }

        return $this->option;
    }

    public function get()
    {
        return $this->option()->get();
    }

    public function getOrElse($default)
    {
        return $this->option()->getOrElse($default);
    }

    public function getOrCall(callable $callable)
    {
        return $this->option()->getOrCall($callable);
    }

    public function getOrThrow(Exception $ex)
    {
        return $this->option()->getOrThrow($ex);
    }

    public function isEmpty(): bool
    {
        return $this->option()->isEmpty();
    }

    public function isDefined(): bool
    {
        return $this->option()->isDefined();
    }

    public function orElse(Option $else): Option
    {
        return $this->option()->orElse($else);
    }

    public function forAll(callable $callable): Option
    {
        return $this->option()->forAll($callable);
    }

    public function map(callable $callable): Option
    {
        return $this->option()->map($callable);
    }


    public function flatMap(callable $callable): Option
    {
        return $this->option()->flatMap($callable);
    }


    public function filter(callable $callable): Option
    {
        return $this->option()->filter($callable);
    }


    public function filterNot(callable $callable): Option
    {
        return $this->option()->filterNot($callable);
    }


    public function select($value): Option
    {
        return $this->option()->select($value);
    }


    public function reject($value): Option
    {
        return $this->option()->reject($value);
    }


    public function foldLeft($initialValue, callable $callable)
    {
        return $this->option()->foldLeft($initialValue, $callable);
    }


    public function foldRight($initialValue, callable $callable)
    {
        return $this->option()->foldRight($initialValue, $callable);
    }

    public function orNull()
    {
        return $this->option()->orNull();
    }

    public function fold(callable $ifEmpty, callable $ifSome)
    {
        return $this->option()->fold($ifEmpty, $ifSome);
    }
}
