# Apply

Apply is a Library that aims to promote and bring functional programming ideas from different languages and 
libraries such as Haskell, Scala, Kotlin, Arrow and Cats to PHP.

This library is designed to be used with PHP 7.4 which does not have a stable release yet. The documentation uses some
of the new syntax (particularly the short closure syntax) for brevity.

## Stability

The library is currently very much a work in progress. Everything could change at any moment.

## Contributing

I'm currently looking for ideas, suggestions, criticisms and contributions. The library is very much in a draft state,
some of the functions probably don't work they way they 'should' and test coverage is still only 50ish percent.

* If you have any ideas for functional programming concepts that could work well in PHP, please open an issue or PR and 
get involved.
* If you see any functions that don't work the way they should, or could be improved performance wise feel free to open
a PR or issue and let me now!
* If you have any ideas, long term visions, or do you just think this whole library is stupid? Feel free to open an 
issue and let me know! 

## Curried Functions
 
### Collections

All of the collection functions in this library attempt to follow a pattern in terms of naming and argument order.
Usually the names and arguments you'll find are taken from Haskell's standard library. Every function has a Curried
version where the argument order matches the one in Haskell. In this argument order the subject of the function is
always the last argument so that the curried functions can be used to create partially applied functions that can
be chained together in different ways. All of these functions also have imperative counterparts that are easier
to use and read in some situations. These functions have the same argument order except that the subject is now
the first argument followed by the other arguments in the same order. This order is chosen because it's easier
to read in imperative code and because it's similar to most other languages.

Functions that return collections of elements will always return Generators in order to be as lazy as possible.
Functions that return a single element or a scalar value are not lazy. 

#### All

```php
$list = [5, 6, 7, 8, 9, 10];

$gt4 = fn($n) => $n > 4;
$gt5 = fn($n) => $n > 5;

all($gt4)($list); // true because all items are greater than 4
all($gt5)($list); // false because not all items are greater than 5
```

#### Any

Returns true if any (or some) of the predicates are true.

```php
$list = [5, 6, 7, 8, 9, 10];

$gt7 = fn($n) => $n > 7;
$gt20 = fn($n) => $n > 20;

any($gt7)($list); // true because all items are greater than 7
any($gt20)($list); // false because none of the items are greater than 20
```


### `identity` and `constant`

These two guys can often be very useful in many situations. `constant` returns a function that always returns the value
that you passed to it. While identity is a function that always returns it's argument.

```php
$numbers = [1,2,3];
map(Functions::identity)($numbers); // [1,2,3]
map(constant(4))($numbers); // [4,4,4]
```

## Monads

Check [this](https://arrow-kt.io/docs/patterns/monads/) page for a good tutorial on what Monads are. You don't really 
have to understand them in order to (ab)use them though.

### Try

`Attempt` represents the result of a computation that can either have a result when the computation was successful or
an exception if something went wrong. If the computation went correctly you get a `Success<A>` containing the result and 
if the computation goes wrong you get a `Failure` containing the exception.

`Attempt` looks a lot like `Either` but is especially useful in situation where you have to consume some library or 
language feature that throws unwanted exception. `Attempt` can be used to to capture exceptions and performing computations
on the result without having to build complicated and verbose `try-catch` blocks. 

```php
function loadFromAPI() {
    throw new InvalidAuthenticationCredentialsException('Your authentication credentials are invalid');
}

$tryLoad = Attempt::of(fn() => loadFromAPI());
$result = $tryLoad->getOrDefault(null); // returns null

if ($tryLoad->isFailure()) {
    // true it went wrong!
}
```

Most often you may want to fold over the computation

```php
$tryLoad = Attempt::of(fn() => rollTheDice());

$number = $tryLoad->fold(
    fn(Throwable $t) => 0,
    fn(int $successValue) => $successValue + 1
);
```

### Option (Maybe)

The Option monad is a modern rewrite of `schmittjoh/php-option` which can be found 
[here](https://github.com/schmittjoh/php-option). It's designed to be mostly compatible with it's interface.

Suggestions are welcome.

### Either


```php

/**
 * @return Either<string, Response>
 */
function loadFromApi(): Either {
    try { 
        return new Right(httpGet("http://example.com"));
    } catch (RequestException $e) {
        return new Left("Request Error");
    } catch (ResponseException $e) {
        return new Left("Response Error");
    }
}

```

Instead of using `string` as type directly you probably want to define your own error types like `RequestError` and 
`ResponseError`. Those types could then have meaningful properties that assist with error handling.  

### EvalM

Wrapper around a lazy computation.

## Monad Comprehensions

Many programming languages have a form of monad comprehensions but they go by different names with slightly different
implementations. In Haskell you have the 'do notation', in Scala you have for-comprehensions and in JavaScript you can 
use async/await to accomplish similar results.

In PHP we don't have much use for asynchronous programming and IO monads, but the syntax of monad comprehensions can
still offer us a way to combine the results of many monads in an elegant way.

First let's look at one example that doesn't look very nice. Here we have two computations that can fail in some way.
In order to combine the results of these computations whe have to take them out of the 'package' that they came in, 
combine the results and wrap them back up. Your code may look something like this.

```php
$computeA = fn() => Option::fromValue(1);
$computeB = fn() => Option::fromValue(5);

$sum = $computeA()->flatMap(static function ($a) use ($computeB) {
    return $computeB()->flatMap(static function ($b) use ($a) {
        return new Some($a + $b);
    });
});

$sum; // Some(6)
```

Now this is already pretty terrible but imagine you want to combine the result of 3 or even 10 options, welcome in 
callback hell.

The solution:

```php
$computeA = fn() => Option::fromValue(1);
$computeB = fn() => Option::fromValue(5);

$sum = Option::binding(static function () use ($computeA, $computeB) {
    $a = yield $computeA();
    $b = yield $computeB();
    return $a + $b;
}); 

$sum; // Some(6)
```

That looks a lot more like the kind of code that you want to write! It's not perfect because we have to wrap the whole
thing in a callable and pass that to the `binding` function. But it's much easier to read then our first example. 
Especially if the amount of computations increases.

## License

Most of the source code in this project is  licensed under MIT. The `Apply\Option` packages is derived from 
`schmittjoh/php-option` which is licensed under Apache-2.0. 

`SPDX-License-Identifier: Apache-2.0 AND MIT`