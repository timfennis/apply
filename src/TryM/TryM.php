<?php


namespace Apply\TryM;

use Apply\Functions;
use Apply\Option\None;
use Apply\Option\Option;
use Apply\Option\Some;
use Throwable;
use function \Apply\constant;

/**
 * Class TryM
 *
 * @internal this class is only supposed te be extended by Success and Failure
 */
abstract class TryM
{
    public static function of(callable $callable)
    {
        try {
            return new Success($callable());
        } catch (Throwable $t) {
            return new Failure($t);
        }
    }

    public static function raiseError(Throwable $throwable)
    {
        return new Failure($throwable);
    }

    public static function just($value)
    {
        return new Success($value);
    }

    public function map(callable $f): TryM
    {
        return $this->flatMap(static function ($value) use ($f) {
            return new Success($f($value));
        });
    }


    public function exists(callable $predicate): bool
    {
        return $this->fold(constant(false), static function ($value) use ($predicate): bool {
            return $predicate($value);
        });
    }

    public function getOrDefault($defaultValue = null)
    {
        return $this->fold(constant($defaultValue), Functions::identity);
    }

    public function getOrElse(callable $ifFailure)
    {
        return $this->fold($ifFailure, Functions::identity);
    }

//    abstract public function get();
    abstract public function flatMap(callable $f): self;

    abstract public function fold(callable $ifFailure, callable $ifSuccess);

    abstract public function isSuccess(): bool;

    abstract public function isFailure(): bool;

    public function toOption(): Option
    {
        return $this->fold(static function () {
            return None::create();
        }, static function ($value) {
            return Some::fromValue($value);
        });
    }
}
