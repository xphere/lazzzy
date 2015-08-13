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
 * Class MapIterator
 *
 * Run a callable in every item on iteration
 *
 * @author Berny Cantos <be@rny.cc>
 */
class MapIterator extends IteratorIterator
{
    /** @var callable */
    private $callback;

    /**
     * Construct
     *
     * @param \Traversable $traversable
     * @param callable     $callback
     */
    public function __construct(\Traversable $traversable, callable $callback)
    {
        parent::__construct($traversable);

        $this->callback = $callback;
    }

    /**
     * Get current element
     *
     * @return mixed
     */
    public function current()
    {
        $callback = $this->callback;

        return $callback(parent::current());
    }
}
