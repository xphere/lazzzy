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

class RewindableIterator extends IteratorIterator
{
    private $cache = array();

    public function rewind()
    {
        parent::rewind();
    }
}
