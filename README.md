Lazzzy
======

Lazy collection library for PHP.

Wrap your iterables in a thin layer of pure lazyness, so they can be lazy-evaluated while you're being lazy too. :D

Why would I want that?
----------------------

Collections are everywhere, but you usually don't want to materialize them in each operation.
That's where lazyness come in handy.
This allows you to map and filter in zero initialization time, for later evaluation when the time is right.

Features
--------

- Convert anything into an iterable: arrays, iterators, functions, generators... you name it. [*]
- Map and filter with multiple functions on initialization, execute once on evaluation
- Handles infinite iterators

[*] planned

Compatibility
-------------

Lazzzy requires PHP 5.4 or higher for basic usage.

Installation
------------

Just use composer to add to your project:
```bash
composer require xphere/lazzzy@dev
```

Usage
-----

NOTE: Lazzzy is still in alpha, so don't rely on current methods. Just sayin'

Functions
---------

### Container::from(x) # lazy

Static function. Converts almost anything into an iterable.
Returns a `Container` object wrapping the iterable.

```php
use Lazzzy\Container;

$container = Container::from(range(0, 1000));
```

### Container::getIterator()

Honors `\IteratorAggregate` interface so you can `foreach` over `Container`s.

### Container::toAssoc() # not lazy

Iterates over the container, applying all transformations.
Returns the resulting array.

```php
use Lazzzy\Container;

$expected = ['a' => 0, 'b' => 1, 'c' => 2];
$container = Container::from($expected);

$values = $container->toAssoc();

$this->assertEquals($expected, $values);
```

### Container::toArray() # not lazy

Like `toAssoc` method, but discards keys.

```php
use Lazzzy\Container;

$expected = [0, 1, 2];
$values = ['a' => 0, 'b' => 1, 'c' => 2];
$container = Container::from($expected);

$values = $container->toAssoc();

$this->assertEquals($expected, $values);
```

### Container::each(fn) # not lazy

Iterates over the container, executing `fn` on each iteration.
Returns nothing.

```php
use Lazzzy\Container;

$echo = function ($item) { echo $item, ', '; };
$container = Container::from(range(0, 5));

$container->each($echo);

/// Outputs "0, 1, 2, 3, " and returns nothing
```

### Container::map(fn) # lazy (a -> b) -> [a] -> [b]

Calls `fn` transformation on each iteration of `[a]`.

```php
use Lazzzy\Container;

$expected = [0, 2, 4, 6];
$double = function ($item) { return $item * 2; };
$container = Container::from(range(0, 3))
    ->map($double)
;

$actual = $container->toArray();

$this->assertSame($expected, $actual);
```

### Container::filter(fn) # lazy (a -> Bool) -> [a] -> [a]

Filters elements for which `fn` function returns truthy values.

```php
use Lazzzy\Container;

$expected = [1, 3];
$odd = function ($item) { return $item % 2 === 1; };
$container = Container::from(range(0, 3))
    ->filter($odd)
;

$actual = $container->toArray();

$this->assertSame($expected, $actual);
```

### Container::take(number) # lazy n -> [a] -> [a]

Takes `n` items from the iterator. `n` must be an integer greater than zero.

```php
use Lazzzy\Container;

$expected = [0, 1];
$container = Container::from(range(0, 3))
    ->take(2)
;

$actual = $container->toArray();

$this->assertSame($expected, $actual);
```

### Container::takeWhile(fn) # lazy n -> [a] -> [a]

Takes items while the condition `fn` is truthy.

```php
use Lazzzy\Container;

$expected = [0, 1];
$notEqualsTwo = function ($item) { return $item !== 2; };
$container = Container::from(range(0, 3))
    ->takeWhile($notEqualsTwo)
;

$actual = $container->toArray();

$this->assertSame($expected, $actual);
```

More to come

- Container::skip(n)
- Container::skipUntil(fn)
- Container::fold(fn, x?)
- Container::foldr(fn, x?)
- Container::find(fn)
- Container::every(fn)
- Container::any(fn)
- Container::size()

Contributions
-------------

Please contribute with the project on [GitHub](https://github.com/xPheRe/lazzzy)

Author
------

Berny Cantos
Contact: [be@rny.cc](mailto:be@rny.cc)
GitHub:  [xPheRe](//github.com/xPheRe)
Twitter: [xPheRe](//twitter.com/xPheRe)

License
-------

Lazzzy is licensed under the MIT License. See LICENSE file for full details.