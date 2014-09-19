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
}
