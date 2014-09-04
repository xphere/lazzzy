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

use Lazzzy\Iterator\TakeWhileIterator;
use Lazzzy\Tests\TestCase;

class TakeWhileIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_all_iterators
     */
    public function test_create_with_valid_iterator(\Iterator $iterator)
    {
        $callback = function () { };
        $takenWhile = new TakeWhileIterator($iterator, $callback);

        $this->assertNotNull($takenWhile);
    }

    /**
     * @dataProvider provider_iteration
     */
    public function test_iteration(\Iterator $iterable, $callback, array $expected)
    {
        $iterator = new TakeWhileIterator($iterable, $callback);
        $actual = iterator_to_array($iterator, false);

        $this->assertSame($expected, $actual);
    }

    public function provider_iteration()
    {
        $emptyIterator = new \EmptyIterator();
        $arrayIterator = new \ArrayIterator([6, 9, 4, 7, 1, 8, 10, 3, 2, 5]);
        $infiniteIterator = new \InfiniteIterator($arrayIterator);

        $always = function () { return true; };
        $never = function () { return false; };
        $moreThanThree = function ($i) { return $i > 3; };
        $lessThanTen = function ($i) { return $i < 10; };

        return [
            'always on empty' => [ $emptyIterator, $always, [] ],
            'never on empty' => [ $emptyIterator, $never, [] ],
            'always on finite' => [ $arrayIterator, $always, [6, 9, 4, 7, 1, 8, 10, 3, 2, 5] ],
            'moreThanThree on finite' => [ $arrayIterator, $moreThanThree, [6, 9, 4, 7] ],
            'never on finite' => [ $arrayIterator, $never, [] ],
            'lessThanTen on infinite' => [ $infiniteIterator, $lessThanTen, [6, 9, 4, 7, 1, 8] ],
            'never from infinite' => [ $infiniteIterator, $never, [] ]
        ];
    }

    public function test_is_lazy()
    {
        $iterable = $this->mockLazyIterator();
        // Even the filter should not be called
        $filter = array($iterable, 'valid');

        new TakeWhileIterator($iterable, $filter);
    }

    public function test_keeps_keys()
    {
        $array = ['first' => 15, 'second' => 10, 'last' => 20];
        $expected = ['first' => 15, 'second' => 10];
        $callback = function ($i) { return $i < 20; };
        $iterable = new \ArrayIterator($array);

        $iterator = new TakeWhileIterator($iterable, $callback);
        $actual = iterator_to_array($iterator);

        $this->assertEquals($expected, $actual);
    }
}
