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

use LimitIterator;

class TakeIterator extends LimitIterator
{
    public function __construct(\Iterator $iterator, $count)
    {
        // Taking 0 or less items is not allowed, use an empty iterator instead
        if ($count <= 0) {
            throw new \OutOfBoundsException('You must take a positive non-zero number of items');
        }

        parent::__construct($iterator, 0, $count);
    }
}
