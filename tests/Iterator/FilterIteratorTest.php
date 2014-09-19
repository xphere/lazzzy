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

use Lazzzy\Iterator\FilterIterator;
use Lazzzy\Tests\TestCase;

class FilterIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_all_iterators
     */
    public function test_create_with_valid_iterator(\Iterator $iterator)
    {
        $callable = function () { };
        $filtered = new FilterIterator($iterator, $callable);

        $this->assertNotNull($filtered);
    }

    /**
     * @dataProvider provider_filters_collection
     */
    public function test_filters_collection(\Iterator $iterator, callable $filter, array $expected)
    {
        $filtered = new FilterIterator($iterator, $filter);
        $actual = iterator_to_array($filtered, false);

        $this->assertEquals($expected, $actual);
    }

    public function provider_filters_collection()
    {
        $iterator = new \ArrayIterator([6, 9, 4, 7, 1, 8, 10, 3, 2, 5]);

        $lessThan = function ($i) { return $i < 5; };
        $isOdd = function ($i) { return $i & 1; };

        return [
            'less than 5' => [ $iterator, $lessThan, [ 4, 1, 3, 2 ] ],
            'odd numbers' => [ $iterator, $isOdd, [ 9, 7, 1, 3, 5 ] ],
        ];
    }

    public function test_is_lazy()
    {
        $iterable = $this->mockLazyIterator();
        // Even the filter should not be called
        $filter = array($iterable, 'valid');

        new FilterIterator($iterable, $filter);
    }
}
