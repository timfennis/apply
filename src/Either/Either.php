<?php


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
     * @phan-param callable(B): C $f
     * @phan-return Either<A, C>
     *
     * @param callable $f
     * @return Either
     */
    abstract public function map(callable $f): Either;

    /**
     * @template C
     * @phan-param callable(B): Either<A, C> $f
     * @phan-return Either<A, C>
     *
     * @param callable $f
     * @return Either
     */
    abstract public function flatMap(callable $f): Either;

    /**
     * @template C
     * @phan-param callable(A): C $ifLeft
     * @phan-param callable(B): C $ifRight
     * @phan-return C
     *
     * @param callable $ifLeft
     * @param callable $ifRight
     * @return mixed
     */
    abstract public function fold(callable $ifLeft, callable $ifRight);

    /**
     * @template C
     * @phan-param C $initial
     * @phan-param callable(C, B): C $rightOperation
     * @phan-return C
     *
     * @param mixed $initial
     * @param callable $rightOperation
     * @return mixed
     */
    abstract public function foldLeft($initial, callable $rightOperation);

    /**
     * @param EvalM $initial
     * @param callable $rightOperation
     * @return EvalM
     *
     * @template C
     * @phan-param EvalM<C> $initial
     * @phan-param callable(B, EvalM<C>): EvalM<C> $rightOperation
     * @phan-return EvalM<C>
     */
    abstract public function foldRight(EvalM $initial, callable $rightOperation): EvalM;

    /**
     * @return bool
     */
    abstract public function isLeft(): bool;

    /**
     * @return bool
     */
    abstract public function isRight(): bool;

    /**
     * @phan-return Either<B, A>
     *
     * @return Either
     */
    abstract public function swap(): Either;

    /**
     * The given function is applied if this is a `Left`.
     *
     * @template C
     * @phan-param callable(A): C $f
     * @phan-return Either<C, B>
     *
     * @param callable $f
     * @return Either
     */
    abstract public function mapLeft(callable $f): Either;


    /**
     * Map over Left and Right of this Either
     *
     * @template C
     * @template D
     * @phan-param callable(A): C $leftOperation
     * @phan-param callable(B): D $rightOperation
     * @phan-return Either<C, D>
     *
     * @param callable $leftOperation
     * @param callable $rightOperation
     * @return Either
     */
    abstract public function bimap(callable $leftOperation, callable $rightOperation): Either;

    /**
     * @phan-param callable(B): bool $predicate
     *
     * @param callable $predicate
     * @return bool
     */
    abstract public function exists(callable $predicate): bool;

    /**
     * @phan-return Option<B>
     *
     * @return Option
     */
    abstract public function toOption(): Option;

    /**
     * Returns the value from this [Either.Right] or the given argument if this is a [Either.Left].
     *
     * @phan-param callable: B $default
     * @phan-return B
     *
     * @param callable $default
     * @return mixed
     */
    abstract public function getOrElse(callable $default);

    /**
     * Returns the value from this [Either.Right] or null if this is a [Either.Left].
     *
     * @phan-return ?B
     *
     * @return mixed
     */
    abstract public function orNull();

    /**
     * Returns the value from this [Either.Right] or allows clients to transform [Either.Left] to [Either.Right] while
     * providing access to the value of [Either.Left].
     *
     * @phan-param callable(A): B $default
     * @phan-return B
     *
     * @param callable $default
     * @return mixed
     */
    abstract public function getOrHandle(callable $default);

    /**
     * @phan-param callable(A): Either<A, B> $handler
     * @phan-return Either<A, B>
     *
     * @param callable $handler
     * @return Either
     */
    abstract public function handleErrorWith(callable $handler): Either;

    /**
     * @template E
     * @template R
     * @phan-param callable(): R $body
     * @phan-return Either<E, R>
     *
     * @param callable $body
     *
     * @return Either
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
