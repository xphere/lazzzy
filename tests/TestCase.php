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
     * Provides all valid iterator classes
     *
     * @return array
     */
    public function provider_all_iterators()
    {
        $empty = new \EmptyIterator();
        $array = new \ArrayIterator();
        $infinite = new \InfiniteIterator($empty);

        return [
            'empty' => [ $empty ],
            'array' => [ $array ],
            'infinite' => [ $infinite ],
        ];
    }

    /**
     * Get a mock iterator for testing purposes
     *
     * @return \Iterator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockIterator()
    {
        return $this->getMock('\Iterator');
    }

    /**
     * Get an iterator whose functions should never be called
     * For testing purposes on lazy iterators
     *
     * @return \Iterator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockLazyIterator()
    {
        $iterable = $this->mockIterator();
        $iterable->expects($this->never())->method('current');
        $iterable->expects($this->never())->method('next');
        $iterable->expects($this->never())->method('key');
        $iterable->expects($this->never())->method('valid');
        $iterable->expects($this->never())->method('rewind');

        return $iterable;
    }
}
