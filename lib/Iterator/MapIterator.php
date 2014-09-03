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

class MapIterator extends IteratorIterator
{
    private $callback;

    public function __construct(\Traversable $traversable, Callable $callback)
    {
        parent::__construct($traversable);

        $this->callback = $callback;
    }

    public function current()
    {
        $callback = $this->callback;

        return $callback(parent::current());
    }
}
