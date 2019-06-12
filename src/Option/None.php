<?php


namespace Apply\Option;

use EmptyIterator;
use Exception;
use RuntimeException;

final class None extends Option
{
    private static $instance;

    public static function create(): None
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getIterator()
    {
        return new EmptyIterator();
    }

    public function get()
    {
        return $this->getOrThrow(new RuntimeException(self::class . ' has no value.'));
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

    private function __construct()
    {
    }
}
