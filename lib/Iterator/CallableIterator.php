<?php

/*
 *  This file is part of the xphere\lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Iterator;

use Iterator;

/**
 * Class CallableIterator
 *
 * Runs a callable in each iteration
 * Supports PHP 5.5 generators
 *
 * @author Berny Cantos <be@rny.cc>
 */
class CallableIterator implements Iterator
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * Holds a possible generator resulting from callable
     *
     * If `false`, callable didn't return a generator, and allows for optimizations
     * If `null`, callable has not been called yet
     *
     * @var \Generator|null|false
     */
    private $generator;

    /**
     * @var integer index
     */
    private $index;

    /**
     * Construct
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Callables and generators can't be rewound
     *
     * Allows a first call to `rewind` for `foreach` purposes
     *
     * @throws \Exception
     */
    public function rewind()
    {
        if ($this->index !== null) {
            throw new \Exception(
                'Cannot rewind a callable that was already run'
            );
        }

        $this->index = 0;
    }

    /**
     * For a callable, it's always valid to iterate
     *
     * @return bool
     */
    public function valid()
    {
        return $this->generator ? $this->generator->valid() : true;
    }

    /**
     * Get current element
     *
     * Takes into account if the callback returns a Generator
     *
     * @return mixed
     */
    public function current()
    {
        if ($this->generator) {
            return $this->generator->current();
        }

        $callable = $this->callable;
        $result = $callable();

        if (!$this->generator && $this->generator !== false) {
            $this->generator = $result instanceof \Generator ? $result : false;

            if ($this->generator) {
                return $this->generator->current();
            }
        }

        return $result;
    }

    /**
     * Get current key
     *
     * @return mixed
     */
    public function key()
    {
        return $this->generator ? $this->generator->key() : $this->index++;
    }

    /**
     * Get next item
     */
    public function next()
    {
        if ($this->generator) {
            $this->generator->next();
        }
    }
}
