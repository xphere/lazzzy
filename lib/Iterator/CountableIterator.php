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

class CountableIterator extends \IteratorIterator
{
    protected $count;

    public function rewind()
    {
        $this->count = 0;
        parent::rewind();
    }

    public function key()
    {
        return $this->count;
    }

    public function next()
    {
        parent::next();
        ++$this->count;
    }
}
