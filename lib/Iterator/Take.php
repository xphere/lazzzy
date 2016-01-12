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
 * Class Take
 *
 * Iterate over a limited subset of items in an iterator
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Take implements \IteratorAggregate
{
    /** @var array|\Traversable */
    private $iterable;

    /** @var int */
    private $count;

    /**
     * Construct
     *
     * @param array|\Traversable $iterable
     * @param integer   $count
     */
    public function __construct($iterable, $count)
    {
        // Taking less than 0 elements is not allowed
        if ($count < 0) {
            throw new \OutOfBoundsException('You must take a positive number of elements');
        }

        $this->iterable = $iterable;
        $this->count = $count;
    }

    public function getIterator()
    {
        $count = $this->count;
        foreach ($this->iterable as $key => $value) {
            if (--$count < 0) {
                break;
            }

            yield $key => $value;
        }
    }
}
