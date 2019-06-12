<?php


namespace Apply\TryM;

use Throwable;

/*sealed*/ abstract class TryM
{
    public static function of(callable $callable)
    {
        try {
            return new Success($callable());
        } catch (Throwable $t) {
            return new Failure($t);
        }
    }

    public function map(callable $callable): TryM
    {
        return $this->flatMap(static function ($value) use ($callable) {
            return new Success($callable($value));
        });
    }

    abstract public function get();
    abstract public function flatMap(callable $callable): self;
    abstract public function isSuccess(): bool;
    abstract public function isFailure(): bool;
}