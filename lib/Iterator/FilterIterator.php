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
 * Class FilterIterator
 *
 * Filters an iterator with a callback
 * Uses SPL `CallbackFilterIterator`
 *
 * @author Berny Cantos <be@rny.cc>
 */
class FilterIterator extends \CallbackFilterIterator
{
}
