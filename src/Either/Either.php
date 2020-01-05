<?php

declare(strict_types=1);

namespace Apply\Either;

use Apply\EvalM\EvalM;
use Apply\Functions;
use Apply\Option\Option;
use Generator;

/**
 * @template A
 * @template B
 */
abstract /* sealed */ class Either
{
    /**
     * @template C
     * @phpstan-param callable(B): C $f
     * @phpstan-return Either<A, C>
     */
    abstract public function map(callable $f): Either;

    /**
     * @template C
     * @phpstan-param callable(B): Either<A, C> $f
     * @phpstan-return Either<A, C>
     */
    abstract public function flatMap(callable $f): Either;

    /**
     * @template C
     * @phpstan-param callable(A): C $ifLeft
     * @phpstan-param callable(B): C $ifRight
     * @phpstan-return C
     *
     * @return mixed
     */
    abstract public function fold(callable $ifLeft, callable $ifRight);

    /**
     * @template C
     * @phpstan-param C $initial
     * @phpstan-param callable(C, B): C $rightOperation
     * @phpstan-return C
     *
     * @param mixed $initial
     *
     * @return mixed
     */
    abstract public function foldLeft($initial, callable $rightOperation);

    /**
     * @template C
     * @phpstan-param EvalM<C> $initial
     * @phpstan-param callable(B, EvalM<C>): EvalM<C> $rightOperation
     * @phpstan-return EvalM<C>
     */
    abstract public function foldRight(EvalM $initial, callable $rightOperation): EvalM;

    abstract public function isLeft(): bool;

    abstract public function isRight(): bool;

    /**
     * @phpstan-return Either<B, A>
     */
    abstract public function swap(): Either;

    /**
     * The given function is applied if this is a `Left`.
     *
     * @template C
     * @phpstan-param callable(A): C $f
     * @phpstan-return Either<C, B>
     */
    abstract public function mapLeft(callable $f): Either;

    /**
     * Map over Left and Right of this Either.
     *
     * @template C
     * @template D
     * @phpstan-param callable(A): C $leftOperation
     * @phpstan-param callable(B): D $rightOperation
     * @phpstan-return Either<C, D>
     */
    abstract public function bimap(callable $leftOperation, callable $rightOperation): Either;

    /**
     * @phpstan-param callable(B): bool $predicate
     */
    abstract public function exists(callable $predicate): bool;

    /**
     * @phpstan-return Option<B>
     */
    abstract public function toOption(): Option;

    /**
     * Returns the value from this [Either.Right] or the given argument if this is a [Either.Left].
     *
     * @phpstan-param callable: B $default
     * @phpstan-return B
     *
     * @return mixed
     */
    abstract public function getOrElse(callable $default);

    /**
     * Returns the value from this [Either.Right] or null if this is a [Either.Left].
     *
     * @phpstan-return ?B
     *
     * @return mixed
     */
    abstract public function orNull();

    /**
     * Returns the value from this [Either.Right] or allows clients to transform [Either.Left] to [Either.Right] while
     * providing access to the value of [Either.Left].
     *
     * @phpstan-param callable(A): B $default
     * @phpstan-return B
     *
     * @return mixed
     */
    abstract public function getOrHandle(callable $default);

    /**
     * @phpstan-param callable(A): Either<A, B> $handler
     * @phpstan-return Either<A, B>
     */
    abstract public function handleErrorWith(callable $handler): Either;

    /**
     * @phpstan-param callable(): A $default
     * @phpstan-return Either<A, B>
     */
    abstract public function leftIfNull(callable $default): Either;

    /**
     * @phpstan-param callable(): bool $predicate
     * @phpstan-param callable(): B $default
     * @phpstan-return Either<A, B>
     */
    abstract public function filterOrElse(callable $predicate, callable $default): Either;

    /**
     * @phpstan-param callable(): bool $predicate
     * @phpstan-param callable(): Left<A> $default
     * @phpstan-return Either<A, B>
     */
    abstract public function filterOrOther(callable $predicate, callable $default): Either;

    /**
     * @template E
     * @template R
     * @phpstan-param callable(): R $body
     * @phpstan-return Either<E, R>
     */
    public static function binding(callable $body): Either
    {
        /** @var Generator $generator */
        $generator = $body();

        /** @var Either $current */
        $current = $generator->current();

        do {
            if ($current instanceof Right) {
                $current = $generator->send($current->fold(Functions::identity, Functions::identity));
            }

            if ($current instanceof Left) {
                return $current;
            }
        } while ($generator->valid());

        return new Right($generator->getReturn());
    }
}
