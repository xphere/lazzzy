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

use Lazzzy\Container;

class ContainerTest extends TestCase
{
    public function test_static_creation()
    {
        $iterator = $this->mockIterator();
        $container = Container::from($iterator);

        $this->assertInstanceOf('Lazzzy\Container', $container);
    }

    public function test_each()
    {
        $actual = [];
        $callback = function ($item) use (&$actual) {
            $actual[] = $item;
        };

        $expected = [1, 2, 3, 4];
        $container = Container::from($expected);
        $container->each($callback);

        $this->assertEquals($expected, $actual);
    }
}
