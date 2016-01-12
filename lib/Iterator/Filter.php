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
 * Class Filter
 *
 * Filters an iterator with a callback
 * Uses SPL `CallbackFilterIterator`
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Filter implements \IteratorAggregate
{
    /** @var array|\Traversable $iterable */
    private $iterable;

    /** @var callable */
    private $filter;

    /**
     * Construct
     *
     * @param array|\Traversable $iterable
     * @param callable $filter
     */
    public function __construct($iterable, callable $filter)
    {
        $this->iterable = $iterable;
        $this->filter = $filter;
    }

    /**
     * Retrieve an iterator
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        $filter = $this->filter;
        foreach ($this->iterable as $key => $value) {
            if ($filter($value)) {
                yield $key => $value;
            }
        }
    }
}
