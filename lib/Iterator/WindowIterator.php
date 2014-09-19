<?php

/*
 *  This file is part of the Berny\Lazzzy project
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lazzzy\Iterator;

class WindowIterator extends \IteratorIterator
{
    private $windowSize;
    private $window = [];
    private $iteration = 0;

    public function __construct(\Traversable $traversable, $windowSize)
    {
        // A window of size 0 or less is not allowed
        if ($windowSize <= 0) {
            throw new \OutOfBoundsException('Window size must be greater than zero');
        }
        $this->windowSize = $windowSize;

        parent::__construct($traversable);
    }

    public function key()
    {
        return $this->iteration;
    }

    public function current()
    {
        return $this->window;
    }

    public function rewind()
    {
        parent::rewind();

        $this->iteration = 0;
        $this->window = [];
        if (parent::valid()) {
            $this->advanceWindow();
        }
    }

    public function next()
    {
        parent::next();

        ++$this->iteration;
        if (parent::valid()) {
            $this->advanceWindow();
        }
    }

    protected function advanceWindow()
    {
        $this->window[\IteratorIterator::key()] = \IteratorIterator::current();
        if (count($this->window) > $this->windowSize) {
            array_shift($this->window);
        }
    }
}
