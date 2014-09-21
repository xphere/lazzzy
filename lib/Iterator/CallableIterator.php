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

use Iterator;

class CallableIterator implements Iterator
{
    private $callable;

    public function __construct(Callable $callable)
    {
        $this->callable = $callable;
    }

    public function rewind()
    {
    }

    public function valid()
    {
        return true;
    }

    public function current()
    {
        $callable = $this->callable;

        return $callable();
    }

    public function key()
    {
    }

    public function next()
    {
    }
}
