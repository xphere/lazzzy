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
use Lazzzy\Tests\TestCase;

class CallableIteratorTest extends TestCase
{
    /**
     * @dataProvider provider_callables
     *
     * @param $callable
     * @param array $expected
     */
    public function test_create_with_valid_callables($callable, array $expected)
    {
        $iterator = new CallableIterator($callable);

        $actual = $this->takeItems($iterator, 4);

        $this->assertEquals($expected, $actual);
    }

    public function provider_callables()
    {
        return [
            'null function' => [
                function () { },
                [ null, null, null, null, ],
            ],
            'constant function' => [
                function () { return 1; },
                [ 1, 1, 1, 1, ],
            ],
            'next function' => [
                function () use (&$num) { return ++$num; },
                [ 1, 2, 3, 4, ],
            ],
            'finite generator' => [
                function () {
                    for ($i = 1; $i < 10; ++$i) {
                        yield $i;
                    }
                },
                [ 1, 2, 3, 4, ],
            ],
            'finite generator with less elements than requested' => [
                function () {
                    yield 1;
                },
                [ 1, ],
            ],
            'infinite generator' => [
                function () {
                    $i = 0;
                    while (true) {
                        yield ++$i;
                    }
                },
                [ 1, 2, 3, 4, ],
            ],
            'should not call more items than needed' => [
                function () {
                    for ($i = 1; $i < 5; ++$i) {
                        yield $i => $i;
                    }

                    throw new \UnexpectedValueException('You should not be here');
                },
                [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, ],
            ]
        ];
    }

    /**
     * @expectedException \Exception
     */
    public function test_rewind_before_iterating_throws()
    {
        $iterator = new CallableIterator(function () { return 1; });

        $this->takeItems($iterator, 1);

        $iterator->rewind();
    }

    public function test_is_lazy()
    {
        $lazyIterator = $this->mockLazyIterator();

        new CallableIterator([$lazyIterator, 'current']);
    }
}
