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
    /**
     * @dataProvider provider_iteration_sources
     */
    public function test_can_generate_from_source_and_iterate($source)
    {
        $container = Container::from($source);

        $this->assertInstanceOf('Lazzzy\Container', $container);

        foreach ($container as $value) {
            break;
        }
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

    public function test_fold_with_initial_value()
    {
        $data = range(0, 9);
        $container = Container::from($data);

        $actual = $container->fold(function ($acc, $value) { return $acc + $value; }, 10);

        $this->assertEquals(55, $actual);
    }

    public function test_fold_with_no_initial_value()
    {
        $data = [5, 9, 2, 7, 1, 3, 8, 6, 4];
        $container = Container::from($data);

        $actual = $container->fold('min');

        $this->assertEquals(1, $actual);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function test_fold_with_no_initial_value_needs_at_least_one_element()
    {
        $container = Container::from([]);
        $container->fold('max');
    }

    public function test_folding_empty_container_returns_initial_value_and_never_calls()
    {
        $container = Container::from([]);
        $initialValue = new \StdClass();

        $callback = function () {

            throw new \UnexpectedValueException(
                'This callback must not be called'
            );
        };

        $actual = $container->fold($callback, $initialValue);

        $this->assertSame($initialValue, $actual);
    }
}
