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

use Lazzzy\Iterator\MapIterator;
use Lazzzy\Tests\TestCase;

class MapIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_valid_iterator
     */
    public function test_create_with_valid_iterator(\Iterator $iterator)
    {
        $callback = function () { };
        $map = new MapIterator($iterator, $callback);

        $this->assertNotNull($map);
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
     * @dataProvider provider_mapping
     */
    public function test_calls_mapping_function_on_iteration($iterator, Callable $callback, array $expected)
    {
        $map = new MapIterator($iterator, $callback);
        $actual = iterator_to_array($map);

        $this->assertEquals($expected, $actual);
    }

    public function provider_mapping()
    {
        $firstFiveNumbers = new \ArrayIterator([1, 2, 3, 4, 5]);

        $forbidden = function() { throw new \BadFunctionCallException('This function should never be called'); };
        $identity = function($value) { return $value; };
        $double = function($value) { return $value * 2; };
        $multiplyBy3 = array($this, 'multiplyBy3');

        return [
            'empty' => [ new \EmptyIterator(), $forbidden, [] ],
            'identity' => [ $firstFiveNumbers, $identity, [1, 2, 3, 4, 5] ],
            'triplicate' => [ $firstFiveNumbers, $multiplyBy3, [3, 6, 9, 12, 15] ],
            'duplicate' => [ $firstFiveNumbers, $double, [2, 4, 6, 8, 10] ],
        ];
    }

    /**
     * To be called as a mapping function
     */
    public function multiplyBy3($value)
    {
        return $value * 3;
    }

    public function test_is_lazy()
    {
        $iterable = $this->mockLazyIterator();
        // Even the callback should not be called
        $callback = array($iterable, 'valid');

        new MapIterator($iterable, $callback);
    }
}
