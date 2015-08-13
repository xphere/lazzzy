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

use IteratorIterator;

/**
 * Class TakeWhileIterator
 *
 * Takes items from an iterable until a condition is match
 *
 * @author Berny Cantos <be@rny.cc>
 */
class TakeWhileIterator extends IteratorIterator
{
    /** @var callable */
    private $condition;

    /**
     * Construct
     *
     * @param \Traversable $traversable
     * @param callable     $condition
     */
    public function __construct(\Traversable $traversable, callable $condition)
    {
        parent::__construct($traversable);

        $this->condition = $condition;
    }

    /**
     * Add condition to validation
     *
     * @return bool
     */
    public function valid()
    {
        $condition = $this->condition;

        return parent::valid() && $condition($this->current());
    }
}
