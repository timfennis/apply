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

use ArrayIterator;
use Exception;
use RuntimeException;
use Apply\Exception\InvalidStateException;
use Traversable;

final class Some extends Option
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getIterator()
    {
        return new ArrayIterator([$this->value]);
    }

    public function get()
    {
        return $this->value;
    }

    public function getOrElse($default)
    {
        return $this->value;
    }

    public function getOrCall(callable $callable)
    {
        return $this->value;
    }

    public function getOrThrow(Exception $ex)
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return false;
    }

    public function isDefined(): bool
    {
        return true;
    }

    public function orElse(Option $else): Option
    {
        return $this;
    }

    public function forAll(callable $callable): Option
    {
        $callable($this->value);
        return $this;
    }

    public function map(callable $callable): Option
    {
        return new self($callable($this->value));
    }

    public function flatMap(callable $callable): Option
    {
        $rs = $callable($this->value);
        if (false === $rs instanceof Option) {
            throw InvalidStateException::invalidCallableReturnType(Option::class, gettype($rs));
        }
        return $rs;
    }

    public function filter(callable $callable): Option
    {
        if (true === $callable($this->value)) {
            return $this;
        }

        return None::create();
    }

    public function filterNot(callable $callable): Option
    {
        if (false === $callable($this->value)) {
            return $this;
        }
        return None::create();
    }

    public function select($value): Option
    {
        if ($this->value === $value) {
            return $this;
        }
        return None::create();
    }

    public function reject($value): Option
    {
        if ($this->value === $value) {
            return None::create();
        }
        return $this;
    }

    public function foldLeft($initialValue, callable $callable)
    {
        return $callable($initialValue, $this->value);
    }

    public function foldRight($initialValue, callable $callable)
    {
        return $callable($this->value, $initialValue);
    }
}
