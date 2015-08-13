<?php

/*
 * This file is part of the xphere\lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy;

use Traversable;

use Lazzzy\Exception;

/**
 * Class Container
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Container implements \IteratorAggregate
{
    /** @var \Iterator */
    private $iterator;

    /**
     * Wraps iterable into a container
     *
     * @return self
     */
    static public function from($iterable)
    {
        return new static(self::fromIterable($iterable));
    }

    /**
     * Honors `\IteratorAggregate` interface so you can `foreach` over `Container`s
     *
     * @return \Iterator
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * Convert to array, with numeric keys
     * - Not lazy, throws on infinite sequences
     *
     * @return array
     */
    public function toArray()
    {
        // TODO: Throw on infinite sequence
        return iterator_to_array($this->iterator, false);
    }

    /**
     * Convert to associative array, keeping keys from iterator
     * - Not lazy, throws on infinite sequences
     *
     * @return array
     */
    public function toAssoc()
    {
        // TODO: Throw on infinite sequence
        return iterator_to_array($this->iterator, true);
    }

    /**
     * Map iterable through a transformation function
     * + Lazy evaluation
     *
     * map(['this', 'is', 'sparta'], 'strrev') -> ['siht', 'si', 'atraps']
     *
     * @param callable $call
     *
     * @return self
     */
    public function map(callable $call)
    {
        return new static(new Iterator\MapIterator($this->iterator, $call));
    }

    /**
     * Run a function for every value
     * - Not lazy, throws on infinite sequences
     *
     * each([$a, $b, $c], function($o) { $o->save(); }) -> void
     *
     * @param callable $call
     *
     * @return $this
     */
    public function each(callable $call)
    {
        // TODO: Throw on infinite sequence
        foreach ($this as $item) {
            $call($item);
        }

        return $this;
    }

    /**
     * Iterate through values that pass a truth test
     * + Lazy evaluation
     *
     * filter([1, '2', 3, null], 'is_int') -> [1, 3]
     *
     * @param callable $predicate
     *
     * @return self
     */
    public function filter(callable $predicate)
    {
        return new static(new Iterator\FilterIterator($this->iterator, $predicate));
    }

    /**
     * Returns first value
     * - Not lazy, but handles infinite sequences
     *
     * head([1, 2, 3]) -> 1
     *
     * @return mixed
     */
    public function head()
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Iterate through first $count values
     * + Lazy evaluation
     *
     * take([1, 2, 3, 4], 2) -> [1, 2]
     *
     * @param integer $count How many items to take
     *
     * @return self
     */
    public function take($count)
    {
        return new static(new Iterator\TakeIterator($this->iterator, $count));
    }

    /**
     * Iterates until a certain predicate turns false
     * + Lazy evaluation
     *
     * takeWhile([1, 2, 3, 4], function($i) { return $i < 3; }) -> [1, 2]
     *
     * @param callable $predicate
     *
     * @return self
     */
    public function takeWhile(callable $predicate)
    {
        return new static(new Iterator\TakeWhileIterator($this->iterator, $predicate));
    }

    /**
     * Skip first $count values
     * + Lazy evaluation
     *
     * skip([1, 2, 3, 4, 5], 2) -> [3, 4, 5]
     *
     * @param integer $count How many elements to skip
     *
     * @return self
     */
    public function skip($count)
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Skip values until a certain predicate turns true
     * + Lazy evaluation
     *
     * skipUntil([1, 2, 3, 4, 5], function($i) { return $i > 3; }) -> [4, 5]
     *
     * @param callable $predicate
     *
     * @return self
     */
    public function skipUntil(callable $predicate)
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Reduces into a single value calling a function
     * - Not lazy, throws on infinite sequences
     *
     * fold([1, 2, 3], '+', 10) -> 16
     *
     * @param callable $callback
     * @param mixed    $initial
     *
     * @return mixed
     */
    public function fold(callable $callback, $initial = null)
    {
        if (func_num_args() > 1) {
            $accumulator = $initial;
        }

        // TODO: Throw on infinite sequence
        foreach ($this->iterator as $item) {
            $accumulator = isset($accumulator)
                ? $callback($item, $accumulator)
                : $item;
        }

        if (!isset($accumulator)) {
            throw new \UnexpectedValueException(
                'Reducing empty collection without initial value'
            );
        }

        return $accumulator;
    }

    /**
     * Right associative version of fold
     * - Not lazy, throws on infinite sequences
     *
     * foldr(['a', 'b', 'c'], '.') -> 'cba'
     *
     * @param callable $callback
     * @param mixed    $initial
     *
     * @return $mixed
     */
    public function foldr(callable $callback, $initial = null)
    {
        if (func_num_args() > 1) {
            return $this->reverse()->fold($callback, $initial);
        }

        return $this->reverse()->fold($callback);
    }

    /**
     * Return a collection iterable in inverse order
     * - Lazy, throws on infinite sequences
     *
     * reverse([7, 2, 9, 3]) -> [3, 9, 2, 7]
     */
    public function reverse()
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Search for a value that passes a truth test
     * - Not lazy, but handles infinite sequences (if any value passes the test)
     *
     * find([7, 2, 9, 3], function($i) { return $i > 8; }) -> 9
     *
     * @param callable $predicate
     *
     * @return mixed
     */
    public function find(callable $predicate)
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Check whether every value passes a truth test or not
     * - Not lazy, but handles infinite sequences (if any value fails the test)
     *
     * every(['a', 'b', 'c'], function($s) { return strlen($s) === 1; }) -> true
     *
     * @param callable $predicate
     *
     * @return boolean
     */
    public function every(callable $predicate)
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Check if any value passes a truth test or not
     * - Not lazy, but handles infinite sequences (if any value passes the test)
     *
     * any(['a', 'b', 'c'], function($s) { return strlen($s) === 2; }) -> false
     *
     * @param callable $predicate
     *
     * @return boolean
     */
    public function any(callable $predicate)
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Caches each execution of an iterator to allow rewind
     * - Lazy, handles infinite sequences (bounded by memory)
     *
     * @return self
     */
    public function rewindable()
    {
        return new static(new Iterator\RewindableIterator($this->iterator));
    }

    /**
     * How many items are there?
     * - Not lazy, throws on infinite sequences
     *
     * @return integer
     */
    public function size()
    {
        /// To be implemented
        throw new Exception\NotImplemented();
    }

    /**
     * Decorate iteration with a window of the specified size.
     * Makes the result of each iteration an array of $windowSize items at most.
     * + Lazy evaluation
     *
     * windowed([1, 2, 3], 2) -> [[1], [1, 2], [2, 3]]
     *
     * @param integer $windowSize
     *
     * @return self
     */
    public function windowed($windowSize)
    {
        return new static(new Iterator\WindowIterator($this->iterator, $windowSize));
    }

    /**
     * Materialize content inside the container
     *
     * @return Container
     */
    public function evaluate()
    {
        return static::from($this->toAssoc());
    }

    /**
     * Disallows creation from the outside to force the usage of `from`
     *
     * @param Traversable $iterator
     */
    private function __construct(\Traversable $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * Generate an iterator from any supported iterable
     *
     * @param mixed $iterable
     *
     * @return \Iterator
     *
     * @throws Exception\UnsupportedIterable
     */
    static private function fromIterable($iterable)
    {
        if ($iterable instanceof \Iterator) {
            return $iterable;
        }

        if ($iterable instanceof \Traversable) {
            return new \IteratorIterator($iterable);
        }

        if (is_array($iterable) && (count($iterable) !== 2 || !is_callable($iterable))) {
            return new \ArrayIterator($iterable);
        }

        if (is_callable($iterable)) {
            return new Iterator\CallableIterator($iterable);
        }

        throw new Exception\UnsupportedIterable();
    }
}
