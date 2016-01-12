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

/**
 * Class Map
 *
 * Run a callable in every item on iteration
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Map implements \IteratorAggregate
{
    /** @var array|\Traversable $iterable */
    private $iterable;

    /** @var callable */
    private $mapping;

    /**
     * Construct
     *
     * @param array|\Traversable $iterable
     * @param callable $callback
     */
    public function __construct($iterable, callable $callback)
    {
        $this->iterable = $iterable;
        $this->mapping = $callback;
    }

    /**
     * Retrieve an iterator
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        $mapping = $this->mapping;
        foreach ($this->iterable as $key => $value) {
            yield $key => $mapping($value);
        }
    }
}
