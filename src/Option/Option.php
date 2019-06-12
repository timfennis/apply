<?php


namespace Apply\Option;

use Closure;
use Exception;
use IteratorAggregate;
use RuntimeException;

abstract class Option implements IteratorAggregate
{
    /**
     * Creates an option given a return value.
     *
     * This is intended for consuming existing APIs and allows you to easily
     * convert them to an option. By default, we treat ``null`` as the None case,
     * and everything else as Some.
     *
     * @param mixed $value The actual return value.
     * @param mixed $noneValue The value which should be considered "None"; null
     *                         by default.
     *
     * @return Option
     */
    public static function fromValue($value, $noneValue = null): Option
    {
        if ($value === $noneValue) {
            return None::create();
        }

        return new Some($value);
    }

    /**
     * Creates an option from an array's value.
     *
     * If the key does not exist in the array, the array is not actually an array, or the
     * array's value at the given key is null, None is returned.
     *
     * Otherwise, Some is returned wrapping the value at the given key.
     *
     * @param mixed $array a potential array value
     * @param string $key the key to check
     *
     * @return Option
     */
    public static function fromArraysValue($array, $key): Option
    {
        if (!isset($array[$key])) {
            return None::create();
        }
        return new Some($array[$key]);
    }

    /**
     * Creates a lazy-option with the given callback.
     *
     * This is also a helper constructor for lazy-consuming existing APIs where
     * the return value is not yet an option. By default, we treat ``null`` as
     * None case, and everything else as Some.
     *
     * @param callable $callback The callback to evaluate.
     * @param array $arguments
     * @param mixed $noneValue The value which should be considered "None"; null
     *                         by default.
     *
     * @return LazyOption
     */
    public static function fromReturn($callback, array $arguments = array(), $noneValue = null): LazyOption
    {
        return new LazyOption(static function () use ($callback, $arguments, $noneValue) {
            $return = $callback(...$arguments);
            if ($return === $noneValue) {
                return None::create();
            }
            return new Some($return);
        });
    }

    /**
     * Option factory, which creates new option based on passed value.
     * If value is already an option, it simply returns
     * If value is a \Closure, LazyOption with passed callback created and returned. If Option returned from callback,
     * it returns directly (flatMap-like behaviour)
     * On other case value passed to Option::fromValue() method
     *
     * @param Option|\Closure|mixed $value
     * @param null $noneValue used when $value is mixed or Closure, for None-check
     *
     * @return Option
     */
    public static function ensure($value, $noneValue = null): Option
    {
        if ($value instanceof self) {
            return $value;
        }

        if ($value instanceof Closure) {
            return new LazyOption(static function () use ($value, $noneValue) {
                $return = $value();

                if ($return instanceof Option) {
                    return $return;
                }

                return Option::fromValue($return, $noneValue);
            });
        }

        return self::fromValue($value, $noneValue);
    }

    /**
     * Returns the value if available, or throws an exception otherwise.
     *
     * @return mixed
     * @throws RuntimeException if value is not available
     *
     */
    abstract public function get();

    /**
     * Returns the value if available, or the default value if not.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    abstract public function getOrElse($default);

    /**
     * Returns the value if available, or the results of the callable.
     *
     * This is preferable over ``getOrElse`` if the computation of the default
     * value is expensive.
     *
     * @param callable $callable
     *
     * @return mixed
     */
    abstract public function getOrCall(callable $callable);

    /**
     * Returns the value if available, or throws the passed exception.
     *
     * @param Exception $ex
     *
     * @return mixed
     */
    abstract public function getOrThrow(Exception $ex);

    /**
     * Returns true if no value is available, false otherwise.
     *
     * @return boolean
     */
    abstract public function isEmpty(): bool;

    /**
     * Returns true if a value is available, false otherwise.
     *
     * @return boolean
     */
    abstract public function isDefined(): bool;

    /**
     * Returns this option if non-empty, or the passed option otherwise.
     *
     * This can be used to try multiple alternatives, and is especially useful
     * with lazy evaluating options:
     *
     * ```php
     *     $repo->findSomething()
     *         ->orElse(new LazyOption(array($repo, 'findSomethingElse')))
     *         ->orElse(new LazyOption(array($repo, 'createSomething')));
     * ```
     *
     * @param Option $else
     *
     * @return Option
     */
    abstract public function orElse(Option $else): Option;

    /**
     * This is similar to map() except that the return value of the callable has no meaning.
     *
     * The passed callable is simply executed if the option is non-empty, and ignored if the
     * option is empty. This method is preferred for callables with side-effects, while map()
     * is intended for callables without side-effects.
     *
     * @param callable $callable
     *
     * @return Option
     */
    abstract public function forAll(callable $callable): Option;

    /**
     * Applies the callable to the value of the option if it is non-empty,
     * and returns the return value of the callable wrapped in Some().
     *
     * If the option is empty, then the callable is not applied.
     *
     * ```php
     *     (new Some("foo"))->map('strtoupper')->get(); // "FOO"
     * ```
     *
     * @param callable $callable
     *
     * @return Option
     */
    abstract public function map(callable $callable): Option;

    /**
     * Applies the callable to the value of the option if it is non-empty, and
     * returns the return value of the callable directly.
     *
     * In contrast to ``map``, the return value of the callable is expected to
     * be an Option itself; it is not automatically wrapped in Some().
     *
     * @param callable $callable must return an Option
     *
     * @return Option
     */
    abstract public function flatMap(callable $callable): Option;

    /**
     * If the option is empty, it is returned immediately without applying the callable.
     *
     * If the option is non-empty, the callable is applied, and if it returns true,
     * the option itself is returned; otherwise, None is returned.
     *
     * @param callable $callable
     *
     * @return Option
     */
    abstract public function filter(callable $callable): Option;

    /**
     * If the option is empty, it is returned immediately without applying the callable.
     *
     * If the option is non-empty, the callable is applied, and if it returns false,
     * the option itself is returned; otherwise, None is returned.
     *
     * @param callable $callable
     *
     * @return Option
     */
    abstract public function filterNot(callable $callable): Option;

    /**
     * If the option is empty, it is returned immediately.
     *
     * If the option is non-empty, and its value does not equal the passed value
     * (via a shallow comparison ===), then None is returned. Otherwise, the
     * Option is returned.
     *
     * In other words, this will filter all but the passed value.
     *
     * @param mixed $value
     *
     * @return Option
     */
    abstract public function select($value): Option;

    /**
     * If the option is empty, it is returned immediately.
     *
     * If the option is non-empty, and its value does equal the passed value (via
     * a shallow comparison ===), then None is returned; otherwise, the Option is
     * returned.
     *
     * In other words, this will let all values through except the passed value.
     *
     * @param mixed $value
     *
     * @return Option
     */
    abstract public function reject($value): Option;

    /**
     * Alias for fold
     *
     * @param $initialValue
     * @param callable $callable
     *
     * @return mixed
     */
    abstract public function foldLeft($initialValue, callable $callable);

    /**
     * foldLeft() but with reversed arguments for the callable.
     *
     * @param mixed $initialValue
     * @param callable $callable function(callable, initialValue): result
     *
     * @return mixed
     */
    abstract public function foldRight($initialValue, callable $callable);

    /**
     * Binary operator for the initial value and the option's value.
     *
     * If empty, the initial value is returned.
     * If non-empty, the callable receives the initial value and the option's value as arguments
     *
     * ```php
     *
     *     $some = new Some(5);
     *     $none = None::create();
     *     $result = $some->foldLeft(1, function($a, $b) { return $a + $b; }); // int(6)
     *     $result = $none->foldLeft(1, function($a, $b) { return $a + $b; }); // int(1)
     *
     *     // This can be used instead of something like the following:
     *     $option = Option::fromValue($integerOrNull);
     *     $result = 1;
     *     if ( ! $option->isEmpty()) {
     *         $result += $option->get();
     *     }
     * ```
     *
     * @param mixed $initialValue
     * @param callable $callable function(initialValue, callable): result
     *
     * @return mixed
     */
    public function fold($initialValue, callable $callable)
    {
        return $this->foldLeft($initialValue, $callable);
    }
}
