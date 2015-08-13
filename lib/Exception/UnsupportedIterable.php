<?php

/*
 *  This file is part of the xphere\lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Exception;

/**
 * Class UnsupportedIterable
 *
 * Thrown when an iterable can't be converted to an iterator
 *
 * @author Berny Cantos <be@rny.cc>
 */
class UnsupportedIterable extends \RuntimeException implements Exception
{
}
