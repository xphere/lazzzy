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

    public function test_to_assoc_mantains_keys()
    {
        $expected = [3 => 'a', 'z' => 'b', 1 => 'c'];
        $container = Container::from($expected);

        $actual = $container->toAssoc();

        $this->assertEquals($expected, $actual);
    }

    public function test_to_array_removes_keys()
    {
        $values = [3 => 'a', 'z' => 'b', 1 => 'c'];
        $expected = ['a', 'b', 'c'];
        $container = Container::from($values);

        $actual = $container->toArray();

        $this->assertEquals($expected, $actual);
    }
}
