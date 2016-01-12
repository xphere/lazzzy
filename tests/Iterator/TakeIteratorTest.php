<?php

/*
 *  This file is part of the xphere\lazzzy test suite
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Tests\Iterator;

use Lazzzy\Iterator\Take;
use Lazzzy\Tests\TestCase;

class TakeIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_all_iterators
     */
    public function test_create_with_valid_iterator(\Iterator $iterator)
    {
        $taken = new Take($iterator, 1);

        $this->assertNotNull($taken);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function test_throw_on_zero_items_taken()
    {
        $iterable = $this->mockIterator();
        new Take($iterable, 0);
    }

    /**
     * @dataProvider provider_iteration
     */
    public function test_iteration(\Iterator $iterable, $count, array $expected)
    {
        $iterator = new Take($iterable, $count);
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
        new Take($this->mockLazyIterator(), 1);
    }

    public function test_keeps_keys()
    {
        $array = ['first' => 15, 'second' => 10, 'last' => 20];
        $expected = ['first' => 15, 'second' => 10];
        $iterable = new \ArrayIterator($array);

        $iterator = new Take($iterable, 2);
        $actual = iterator_to_array($iterator);

        $this->assertEquals($expected, $actual);
    }
}
