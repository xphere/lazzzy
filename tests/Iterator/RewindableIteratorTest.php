<?php

/* This file is part of the Berny\Lazzzy test suite
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Tests\Iterator;

use Lazzzy\Iterator\CallableIterator;
use Lazzzy\Iterator\RewindableIterator;
use Lazzzy\Tests\TestCase;

class RewindableIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_all_iterators
     */
    public function test_create_with_valid_iterator(\Iterator $iterator)
    {
        $rewindable = new RewindableIterator($iterator);

        $this->assertNotNull($rewindable);
    }

    /**
     * @dataProvider provider_iteration
     */
    public function test_can_rewind_after_iteration(\Iterator $iterable, array $expected)
    {
        $iterator = new RewindableIterator($iterable);
        $first = iterator_to_array($iterator);
        $second = iterator_to_array($iterator);

        $this->assertSame($expected, $first);
        $this->assertSame($expected, $second);
    }

    public function provider_iteration()
    {
        $emptyIterator = new \EmptyIterator();
        $arrayIterator = new \ArrayIterator([1, 2, 3, 4, 5, ]);
        $callableIterator = new CallableIterator(function () {
            yield 1 => 1;
            yield 2 => 2;
            yield 3 => 3;
            yield 4 => 4;
            yield 5 => 5;
        });

        return [
            'empty' => [ $emptyIterator, [] ],
            'elements' => [ $arrayIterator, [1, 2, 3, 4, 5, ] ],
            'callable' => [ $callableIterator, [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, ] ],
        ];
    }

    public function test_is_lazy()
    {
        new RewindableIterator($this->mockLazyIterator());
    }

    public function test_keeps_keys_internally()
    {
        $expected = ['first' => 15, 'second' => 10, 'last' => 20];
        $iterable = new \ArrayIterator($expected);

        $iterator = new RewindableIterator($iterable);
        $actual = iterator_to_array($iterator);

        $this->assertEquals($expected, $actual);
    }
}
