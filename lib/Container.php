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
    /** @var array|\Traversable */
    private $iterable;

    /**
     * Wraps iterable into a container
     *
     * Allows for multiple iterables
     *
     * @return self
     */
    static public function from($iterable)
    {
        if (func_num_args() > 1) {
            return new static(new Iterator\Append(func_get_args()));
        }

        return new static($iterable);
    }

    /**
     * Honors `\IteratorAggregate` interface so you can `foreach` over `Container`s
     *
     * @return \Traversable
     *
     * @throws Exception\UnsupportedIterable
     */
    public function getIterator()
    {
/* */
        foreach ($this->iterable as $value) {
            yield $value;
        }
/*/
        if ($this->iterable instanceof \Traversable) {
            return $this->iterable;
        }

        if (is_array($this->iterable)) {
            return new \ArrayIterator($this->iterable);
        }

        throw new Exception\UnsupportedIterable();
/* */
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
        return iterator_to_array($this->getIterator(), false);
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
        return iterator_to_array($this->getIterator(), true);
    }

    /**
     * Map iterable through a transformation function
     * + Lazy evaluation
     *
     * map(['this', 'is', 'sparta'], 'strrev') -> ['siht', 'si', 'atraps']
     *
     * @param callable $mapping
     *
     * @return self
     */
    public function map(callable $mapping)
    {
        return new static(new Iterator\Map($this->iterable, $mapping));
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
        return new static(new Iterator\Filter($this->iterable, $predicate));
    }

    /**
     * Returns first value
     * - Not lazy, but handles infinite sequences
     *
     * head([1, 2, 3]) -> 1
     *
     * @return mixed
     *
     * @throws Exception\NotAvailableOnEmpty
     */
    public function head()
    {
        foreach ($this->iterable as $value) {
            return $value;
        }

        /// To be implemented
        throw new Exception\NotAvailableOnEmpty;
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
        return new static(new Iterator\Take($this->iterable, $count));
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
        return new static(new Iterator\TakeWhile($this->iterable, $predicate));
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
        foreach ($this->iterable as $item) {
            $accumulator = isset($accumulator)
                ? $callback($item, $accumulator)
                : $item;
        }

        if (!isset($accumulator)) {
            throw new Exception\NotAvailableOnEmpty(
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
        foreach ($this->iterable as $value) {
            if (!$predicate($value)) {
                return false;
            }
        }

        return true;
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
        foreach ($this->iterable as $value) {
            if ($predicate($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * How many items are there?
     * - Not lazy, throws on infinite sequences
     *
     * @return integer
     */
    public function size()
    {
        $count = 0;
        foreach ($this->iterable as $unusedValue) {
            ++$count;
        }

        return $count;
    }

    /**
     * Decorate iteration with a window of the specified size.
     * Makes the result of each iteration an array of $windowSize items at most.
     * + Lazy evaluation
     *
     * windowed([1, 2, 3], 2) -> [[1], [1, 2], [2, 3]]
     *
     * @param integer $size
     * @param bool $full
     *
     * @return Container
     */
    public function windowed($size, $full = false)
    {
        return new static(new Iterator\Window($this->iterable, $size, $full));
    }

    /**
     * Materialize content inside the container
     *
     * @return Container
     */
    public function evaluate()
    {
        return new static($this->toAssoc());
    }

    /**
     * Disallows creation from the outside to force the usage of `from`
     *
     * @param array|\Traversable $iterable
     */
    private function __construct($iterable)
    {
        $this->iterable = $iterable;
    }
}

