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

/**
 * Class CompositeIterator
 *
 * Iterate over multiple iterators as if it was only one
 *
 * @author Berny Cantos <be@rny.cc>
 */
class CompositeIterator extends \AppendIterator
{
    /**
     * Construct
     *
     * @param array $iterators
     */
    public function __construct(array $iterators)
    {
        parent::__construct();

        foreach ($iterators as $iterator) {
            $this->append($iterator);
        }
    }
}
