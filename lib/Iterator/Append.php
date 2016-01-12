<?php

/*
 * This file is part of the xphere\lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Iterator;

class Append implements \IteratorAggregate
{
    private $iterators;

    /**
     * Construct
     *
     * @param array $iterators
     */
    public function __construct(array $iterators = [])
    {
        $this->iterators = $iterators;
    }

    /**
     * Retrieve an iterator
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        foreach ($this->iterators as $iterator) {
            foreach ($iterator as $key => $value) {
                yield $key => $value;
            }
        }
    }
}
