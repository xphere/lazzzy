<?php

/*
 *  This file is part of the Berny\Lazzzy test suite
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Tests\Iterator;

use Lazzzy\Iterator\TakeIterator;
use Lazzzy\Tests\TestCase;

class TakeIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_valid_iterator
     */
    public function test_create_with_valid_iterator(\Iterator $iterator)
    {
        $taken = new TakeIterator($iterator, 1);

        $this->assertNotNull($taken);
    }

    public function provider_valid_iterator()
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
     * @expectedException \OutOfBoundsException
     */
    public function test_throw_on_zero_items_taken()
    {
        $iterable = $this->getMock('\Iterator');
        new TakeIterator($iterable, 0);
    }

    /**
     * @dataProvider provider_iteration
     */
    public function test_iteration(\Iterator $iterable, $count, array $expected)
    {
        $iterator = new TakeIterator($iterable, $count);
        $actual = iterator_to_array($iterator, false);

        $this->assertSame($expected, $actual);
    }

    public function provider_iteration()
    {
        $emptyIterator = new \EmptyIterator();
        $arrayIterator = new \ArrayIterator([1, 2, 3, 4, 5, ]);
        $infiniteIterator = new \InfiniteIterator($arrayIterator);

        return [
            'elements from empty' => [ $emptyIterator, 2, [] ],
            'less elements' => [ $arrayIterator, 2, [1, 2, ] ],
            'more elements' => [ $arrayIterator, 8, [1, 2, 3, 4, 5, ] ],
            'finite number from infinite' => [ $infiniteIterator, 8, [1, 2, 3, 4, 5, 1, 2, 3, ] ]
        ];
    }

    public function test_is_lazy()
    {
        new TakeIterator($this->mockLazyIterator(), 1);
    }

    public function test_keeps_keys()
    {
        $array = ['first' => 15, 'second' => 10, 'last' => 20];
        $expected = ['first' => 15, 'second' => 10];
        $iterable = new \ArrayIterator($array);

        $iterator = new TakeIterator($iterable, 2);
        $actual = iterator_to_array($iterator);

        $this->assertEquals($expected, $actual);
    }
}
