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

use Lazzzy\Iterator\WindowIterator;
use Lazzzy\Tests\TestCase;

class WindowIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_all_iterators
     */
    public function test_create_with_valid_iterator(\Iterator $iterator)
    {
        $windowed = new WindowIterator($iterator, 1);

        $this->assertNotNull($windowed);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function test_throw_on_zero_items_taken()
    {
        $iterable = $this->mockIterator();
        new WindowIterator($iterable, 0);
    }

    /**
     * @dataProvider provider_iteration
     */
    public function test_iteration(\Iterator $iterable, $count, array $expected)
    {
        $iterator = new WindowIterator($iterable, $count);
        $actual = iterator_to_array($iterator, false);

        $this->assertSame($expected, $actual);
    }

    public function provider_iteration()
    {
        $emptyIterator = new \EmptyIterator();
        $arrayIterator = new \ArrayIterator([1, 2, 3, 4, 5, ]);

        return [
            'empty' => [ $emptyIterator, 2, [] ],
            'less elements' => [ $arrayIterator, 2, [ [1], [1, 2], [2, 3], [3, 4], [4, 5], ] ],
            'more elements' => [ $arrayIterator, 6, [ [1], [1, 2], [1, 2, 3], [1, 2, 3, 4], [1, 2, 3, 4, 5], ] ],
        ];
    }

    public function test_is_lazy()
    {
        new WindowIterator($this->mockLazyIterator(), 1);
    }

    public function test_keeps_keys_internally()
    {
        $array = ['first' => 15, 'second' => 10, 'last' => 20];
        $iterable = new \ArrayIterator($array);
        $expected = [
            ['first' => 15],
            ['first' => 15, 'second' => 10],
            ['second' => 10, 'last' => 20],
        ];

        $iterator = new WindowIterator($iterable, 2);
        $actual = iterator_to_array($iterator);

        $this->assertEquals($expected, $actual);
    }
}
