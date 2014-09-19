<?php

/*
 *  This file is part of the Berny\Lazzzy test suite
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Tests;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Get an iterator whose functions should never be called
     * For testing purposes on lazy iterators
     *
     * @return \Iterator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockLazyIterator()
    {
        $iterable = $this->getMock('\Iterator');
        $iterable->expects($this->never())->method('current');
        $iterable->expects($this->never())->method('next');
        $iterable->expects($this->never())->method('key');
        $iterable->expects($this->never())->method('valid');
        $iterable->expects($this->never())->method('rewind');

        return $iterable;
    }
}
