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

use LimitIterator;

/**
 * Class TakeIterator
 *
 * Iterate over a limited subset of items in an iterator
 *
 * @author Berny Cantos <be@rny.cc>
 */
class TakeIterator extends LimitIterator
{
    /**
     * Construct
     *
     * @param \Iterator $iterator
     * @param integer   $count
     */
    public function __construct(\Iterator $iterator, $count)
    {
        // Taking 0 or less items is not allowed, use an empty iterator instead
        if ($count <= 0) {
            throw new \OutOfBoundsException('You must take a positive non-zero number of items');
        }

        parent::__construct($iterator, 0, $count);
    }
}
