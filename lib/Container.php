<?php

/*
 * This file is part of the Berny\Lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy;

use Traversable;

class Container implements \IteratorAggregate
{
    /** @var \Iterator */
    private $iterator;

    /**
     * Wraps iterable into a suitable iterator
     *
     * iterator(iterable) -> container
     */
    static public function iterator($iterable)
    {
        return new static(self::fromIterable($iterable));
    }

    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * Map iterable through a transformation function
     * + Lazy evaluation
     *
     * map(['this', 'is', 'sparta'], 'strrev') -> ['siht', 'si', 'atraps']
     */
    public function map(Callable $call)
    {
        return new static(new Iterator\MapIterator($this->iterator, $call));
    }

    /**
     * Run a function for every value
     * - Not lazy, throws on infinite sequences
     *
     * each([$a, $b, $c], function($o) { $o->save(); }) -> void
     */
    public function each(Callable $call)
    {
    }

    /**
     * Iterate through values that pass a truth test
     * + Lazy evaluation
     *
     * filter([1, '2', 3, null], 'is_int') -> [1, 3]
     */
    public function filter(Callable $predicate)
    {
        return new static(new Iterator\FilterIterator($this->iterator, $predicate));
    }

    /**
     * Returns first value
     * - Not lazy, but handles infinite sequences
     *
     * head([1, 2, 3]) -> 1
     */
    public function head()
    {
    }

    /**
     * Iterate through first $count values
     * + Lazy evaluation
     *
     * take([1, 2, 3, 4], 2) -> [1, 2]
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
     */
    public function takeWhile(Callable $predicate)
    {
        return new static(new Iterator\TakeWhileIterator($this->iterator, $predicate));
    }

    /**
     * Skip first $count values
     * + Lazy evaluation
     *
     * skip([1, 2, 3, 4, 5], 2) -> [3, 4, 5]
     */
    public function skip($count)
    {
    }

    /**
     * Skip values until a certain predicate turns true
     * + Lazy evaluation
     *
     * skipUntil([1, 2, 3, 4, 5], function($i) { return $i > 3; }) -> [4, 5]
     */
    public function skipUntil(Callable $predicate)
    {
    }

    /**
     * Reduces into a single value calling a function
     * - Not lazy, throws on infinite sequences
     *
     * fold([1, 2, 3], '+', 10) -> 16
     */
    public function fold(Callable $callback, $initial = null)
    {
    }

    /**
     * Right associative version of fold
     * - Not lazy, throws on infinite sequences
     *
     * foldr(['a', 'b', 'c'], '.') -> 'cba'
     */
    public function foldr(Callable $callback, $initial = null)
    {
    }

    /**
     * Search for a value that passes a truth test
     * - Not lazy, but handles infinite sequences (if any value passes the test)
     *
     * find([7, 2, 9, 3], function($i) { return $i > 8; }) -> 9
     */
    public function find(Callable $predicate)
    {
    }

    /**
     * Check whether every value passes a truth test or not
     * - Not lazy, but handles infinite sequences (if any value fails the test)
     *
     * every(['a', 'b', 'c'], function($s) { return strlen($s) === 1; }) -> true
     */
    public function every(Callable $predicate)
    {
    }

    /**
     * Check if any value passes a truth test or not
     * - Not lazy, but handles infinite sequences (if any value passes the test)
     *
     * any(['a', 'b', 'c'], function($s) { return strlen($s) === 2; }) -> false
     */
    public function any(Callable $predicate)
    {
    }

    /**
     * How many items are there?
     * - Not lazy, throws on infinite sequences
     */
    public function size()
    {
    }

    private function __construct(\Traversable $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @param $iterable
     *
     * @return \Iterator
     * @throws \UnexpectedValueException
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

        throw new \UnexpectedValueException('Can\'t extract an iterator');
    }
}
