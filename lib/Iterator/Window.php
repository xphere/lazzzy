<?php

/*
 *  This file is part of the xphere\lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Iterator;

/**
 * Class Window
 *
 * Works with a slider window of fixed size collecting elements from an iterable
 *
 * @author Berny Cantos <be@rny.cc>
 */
class Window implements \IteratorAggregate
{
    /**
     * @var array|\Traversable
     */
    private $iterable;

    /**
     * Size of the window
     *
     * @var integer
     */
    private $size;

    /**
     * Whether the window should be full before starting iteration
     *
     * @var bool
     */
    private $full;

    /**
     * Construct
     *
     * @param array|\Traversable $iterable
     * @param integer $size
     * @param bool $full
     */
    public function __construct($iterable, $size, $full)
    {
        // A window of size 0 or less is not allowed
        if ($size <= 0) {
            throw new \OutOfBoundsException('Window size must be greater than zero');
        }

        $this->size = $size;
        $this->iterable = $iterable;
        $this->full = $full;
    }

    public function getIterator()
    {
        $window = [];
        foreach ($this->iterable as $key => $value) {
            $window[$key] = $value;
            $count = count($window);
            if ($this->full && $count < $this->size) {
                continue;
            }

            if ($count > $this->size) {
                array_shift($window);
            }

            yield $window;
        }
    }
}
