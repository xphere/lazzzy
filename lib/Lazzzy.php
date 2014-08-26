<?php

namespace Lazzzy;

final class Lazzzy
{
    /**
     * Wraps iterable into a suitable iterator
     *
     * iterator(iterable) -> iterator
     */
    static public function iterator($iterable)
    {
    }

    /**
     * Map iterable through a transformation function
     * + Lazy evaluation
     *
     * map(['this', 'is', 'sparta'], 'strrev') -> ['siht', 'si', 'atraps']
     */
    static public function map($iterable, $call)
    {
    }

    /**
     * Run a function for every value
     * - Not lazy, throws on infinite sequences
     *
     * each([$a, $b, $c], function($o) { $o->save(); }) -> void
     */
    static public function each($iterable, Callable $call)
    {
    }

    /**
     * Iterate through values that pass a truth test
     * + Lazy evaluation
     *
     * filter([1, '2', 3, null], 'is_int') -> [1, 3]
     */
    static public function filter($iterable, $predicate)
    {
    }

    /**
     * Returns first value
     * - Not lazy, but handles infinite sequences
     *
     * head([1, 2, 3]) -> 1
     */
    static public function head($iterable)
    {
    }

    /**
     * Iterate through first $count values
     * + Lazy evaluation
     *
     * take([1, 2, 3, 4], 2) -> [1, 2]
     */
    static public function take($iterable, $count)
    {
    }

    /**
     * Iterates until a certain predicate turns false
     * + Lazy evaluation
     *
     * takeWhile([1, 2, 3, 4], function($i) { return $i < 3; }) -> [1, 2]
     */
    static public function takeWhile($iterable, $predicate)
    {
    }

    /**
     * Skip first $count values
     * + Lazy evaluation
     *
     * skip([1, 2, 3, 4, 5], 2) -> [3, 4, 5]
     */
    static public function skip($iterable, $count)
    {
    }

    /**
     * Skip values until a certain predicate turns true
     * + Lazy evaluation
     *
     * skipUntil([1, 2, 3, 4, 5], function($i) { return $i > 3; }) -> [4, 5]
     */
    static public function skipUntil($iterable, $predicate)
    {
    }

    /**
     * Reduces into a single value calling a function
     * - Not lazy, throws on infinite sequences
     *
     * fold([1, 2, 3], '+', 10) -> 16
     */
    static public function fold($iterable, $callback, $initial = null)
    {
    }

    /**
     * Right associative version of fold
     * - Not lazy, throws on infinite sequences
     *
     * foldr(['a', 'b', 'c'], '.') -> 'cba'
     */
    static public function foldr($iterable, $callback, $initial = null)
    {
    }

    /**
     * Search for a value that passes a truth test
     * - Not lazy, but handles infinite sequences (if any value passes the test)
     *
     * find([7, 2, 9, 3], function($i) { return $i > 8; }) -> 9
     */
    static public function find($iterable, $predicate)
    {
    }

    /**
     * Check whether every value passes a truth test or not
     * - Not lazy, but handles infinite sequences (if any value fails the test)
     *
     * every(['a', 'b', 'c'], function($s) { return strlen($s) === 1; }) -> true
     */
    static public function every($iterable, $predicate)
    {
    }

    /**
     * Check if any value passes a truth test or not
     * - Not lazy, but handles infinite sequences (if any value passes the test)
     *
     * any(['a', 'b', 'c'], function($s) { return strlen($s) === 2; }) -> false
     */
    static public function any($iterable, $predicate)
    {
    }

    /**
     * How many items are there?
     * - Not lazy, throws on infinite sequences
     */
    static public function size($iterable)
    {
    }
}
