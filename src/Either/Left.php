<?php


namespace Apply\Either;

use Apply\EvalM\EvalM;
use Apply\Option\None;
use Apply\Option\Option;

/**
 * Class Left
 *
 * @inherits A
 */
class Left extends Either
{
    /**
     * @var mixed
     * @phan-var A
     */
    private $value;

    /**
     * @param mixed $value
     * @phan-param A $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function map(callable $f): Either
    {
        return $this;
    }

    public function flatMap(callable $f): Either
    {
        return $this;
    }

    public function fold(callable $ifLeft, callable $ifRight)
    {
        return $ifLeft($this->value);
    }

    public function foldLeft($initial, callable $rightOperation)
    {
        return $initial;
    }


    public function foldRight(EvalM $initial, callable $rightOperation): EvalM
    {
        return $initial;
    }

    public function isLeft(): bool
    {
        return true;
    }

    public function isRight(): bool
    {
        return false;
    }

    public function swap(): Either
    {
        return new Right($this->value);
    }

    public function mapLeft(callable $f): Either
    {
        return new self($f($this->value));
    }

    public function bimap(callable $leftOperation, callable $rightOperation): Either
    {
        return $this->mapLeft($leftOperation);
    }

    public function exists(callable $predicate): bool
    {
        return false;
    }

    public function toOption(): Option
    {
        return None::create();
    }

    public function getOrElse(callable $default)
    {
        return $default();
    }

    public function orNull()
    {
        return null;
    }

    public function getOrHandle(callable $default)
    {
        return $default($this->value);
    }

    public function handleErrorWith(callable $handler): Either
    {
        return $handler($this->value);
    }
}
