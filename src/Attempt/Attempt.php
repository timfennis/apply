<?php


namespace Apply\Attempt;

use Apply\Functions;
use Apply\Option\None;
use Apply\Option\Option;
use Apply\Option\Some;
use Generator;
use Throwable;
use function \Apply\constant;

/**
 * Class Attempt
 *
 * @internal this class is only supposed te be extended by Success and Failure
 */
abstract class Attempt
{
    public static function of(callable $callable)
    {
        try {
            return new Success($callable());
        } catch (Throwable $t) {
            return new Failure($t);
        }
    }

    public static function raiseError(Throwable $throwable): Failure
    {
        return new Failure($throwable);
    }

    public static function just($value): Success
    {
        return new Success($value);
    }

    public function map(callable $f): Attempt
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

    /**
     * @template A
     * @phan-param callable(): Attempt<A> $callable
     * @phan-return Attempt<A>
     *
     * @param callable $callable
     *
     * @return Attempt
     */
    public static function binding(callable $callable): Attempt
    {
        /** @var Generator $generator */
        $generator = $callable();

        /** @var Attempt $current */
        $current = $generator->current();

        do {
            if ($current instanceof Success) {
                $current = $generator->send($current->fold(Functions::identity, Functions::identity));
            }

            if ($current instanceof Failure) {
                return $current;
            }
        } while ($generator->valid());

        return Attempt::just($generator->getReturn());
    }
}
