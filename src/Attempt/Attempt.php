<?php

declare(strict_types=1);

namespace Apply\Attempt;

use function Apply\constant;
use Apply\Either\Either;
use Apply\Functions;
use Apply\Option\None;
use Apply\Option\Option;
use Apply\Option\Some;
use Generator;
use Throwable;

/**
 * Class Attempt.
 *
 * @phpstan-template T
 *
 * @internal this class is only supposed te be extended by Success and Failure
 */
abstract class Attempt
{
    /**
     * @param callable $callable
     *
     * @return Attempt
     *
     * @phpstan-param callable(): T $callable
     * @phpstan-return Attempt<T>
     */
    public static function of(callable $callable): Attempt
    {
        try {
            return new Success($callable());
        } catch (Throwable $t) {
            return new Failure($t);
        }
    }

    /**
     * @phpstan-param T&Throwable $throwable
     * @phpstan-return Failure<T>
     */
    public static function raiseError(Throwable $throwable): Failure
    {
        return new Failure($throwable);
    }

    /**
     * @phpstan-template P
     * @phpstan-param P $value
     * @phpstan-return Success<P>
     */
    public static function just($value): Success
    {
        return new Success($value);
    }

    /**
     * @phpstan-template R
     * @phpstan-param callable(T): R $f
     * @phpstan-return Attempt<R>
     */
    public function map(callable $f): Attempt
    {
        return $this->flatMap(static fn($value): Success => new Success($f($value)));
    }

    /**
     * @phpstan-param callable(T): bool $predicate
     * @phpstan-return bool
     */
    public function exists(callable $predicate): bool
    {
        return $this->fold(constant(false), static fn($value): bool => $predicate($value));
    }

    /**
     * @phpstan-param T $defaultValue
     * @phpstan-return T
     */
    public function getOrDefault($defaultValue = null)
    {
        return $this->fold(constant($defaultValue), Functions::identity);
    }

    /**
     * @phpstan-param callable(): T $ifFailure
     * @phpstan-return T
     */
    public function getOrElse(callable $ifFailure)
    {
        return $this->fold($ifFailure, Functions::identity);
    }

    /**
     * @phpstan-template R
     * @phpstan-param callable(T): Attempt<R> $f
     * @phpstan-return Attempt<R>
     */
    abstract public function flatMap(callable $f): self;

    /**
     * @phpstan-template R
     * @phpstan-param callable(\Throwable): R $ifFailure
     * @phpstan-param callable(T): R $ifSuccess
     * @phpstan-return R
     */
    abstract public function fold(callable $ifFailure, callable $ifSuccess);

    abstract public function isSuccess(): bool;

    abstract public function isFailure(): bool;

    /**
     * Convenience method to convert an instance of Attempt in to an Either. Because [mapLeft] is often used right after
     * an toEither call an optional argument [$onLeft] is available to convert the type of the error.
     *
     * @param callable|null $onLeft optional function to map over the left value of the either
     *
     * @phpstan-template L
     * @phpstan-param null|callable(Throwable): L $onLeft
     * @phpstan-return Either<L, T>
     */
    abstract public function toEither(?callable $onLeft = null): Either;

    /**
     * @phpstan-return Option<T>
     */
    public function toOption(): Option
    {
        return $this->fold(
            static fn () => None::create(),
            static fn ($value) => Some::fromValue($value)
        );
    }

    /**
     * @phpstan-template A
     * @phpstan-param callable(): Generator<Attempt<A>> $callable
     * @phpstan-return Attempt<A>
     */
    public static function binding(callable $callable): Attempt
    {
        /** @var Generator $generator */
        /** @phpstan-var Generator<Attempt<A>> $generator */
        $generator = $callable();

        /** @phpstan-var Attempt<A> $current */
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
