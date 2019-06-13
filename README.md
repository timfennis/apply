# Apply

Apply is a Library that aims to promote and bring functional programming ideas from different languages and 
libraries such as Haskell, Scala, Kotlin, Arrow and Cats to PHP.

The library is currently very much a work in progress.

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

#### Some

```php
$list = [5, 6, 7, 8, 9, 10];

$gt7 = fn($n) => $n > 7;
$gt20 = fn($n) => $n > 20;

some($gt7)($list); // true because all items are greater than 7
some($gt20)($list); // false because none of the items are greater than 20
```

## Monads

### Try

### Option

### Either