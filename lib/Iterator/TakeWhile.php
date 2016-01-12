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

use Traversable;

/**
 * Class TakeWhile
 *
 * Takes items from an iterable until a condition is match
 *
 * @author Berny Cantos <be@rny.cc>
 */
class TakeWhile implements \IteratorAggregate
{
    /** @var callable */
    private $condition;
    /**
     * @var array|Traversable
     *
     *
     */
    private $iterable;

    /**
     * Construct
     *
     * @param array|\Traversable $iterable
     * @param callable $condition
     */
    public function __construct($iterable, callable $condition)
    {
        $this->iterable = $iterable;
        $this->condition = $condition;
    }

    /**
     * Retrieve an iterator
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        $condition = $this->condition;
        foreach ($this->iterable as $key => $value) {
            if (!$condition($value)) {
                break;
            }

            yield $key => $value;
        }
    }
}
