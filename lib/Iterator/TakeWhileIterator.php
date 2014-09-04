<?php

/*
 *  This file is part of the Berny\Lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Iterator;

use IteratorIterator;

class TakeWhileIterator extends IteratorIterator
{
    private $condition;

    public function __construct(\Traversable $traversable, Callable $condition)
    {
        parent::__construct($traversable);

        $this->condition = $condition;
    }

    public function valid()
    {
        $condition = $this->condition;

        return parent::valid() && $condition($this->current());
    }
}
