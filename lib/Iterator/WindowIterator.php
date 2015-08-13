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
 * Class WindowIterator
 *
 * Works with a slider window of fixed size collecting elements from an iterable
 *
 * @author Berny Cantos <be@rny.cc>
 */
class WindowIterator extends \IteratorIterator
{
    /**
     * Size of the window
     *
     * @var integer
     */
    private $windowSize;

    /**
     * Elements collected in the window
     *
     * @var array
     */
    private $window = [];

    /**
     * Number of iterations
     *
     * @var int
     */
    private $count = 0;

    /**
     * Construct
     *
     * @param \Traversable $traversable
     * @param integer      $windowSize
     */
    public function __construct(\Traversable $traversable, $windowSize)
    {
        // A window of size 0 or less is not allowed
        if ($windowSize <= 0) {
            throw new \OutOfBoundsException('Window size must be greater than zero');
        }
        $this->windowSize = $windowSize;

        parent::__construct($traversable);
    }

    /**
     * Rewind iteration
     */
    public function rewind()
    {
        parent::rewind();

        $this->count = 0;
        $this->window = [];
        if (parent::valid()) {
            $this->advanceWindow();
        }
    }

    /**
     * Get current element
     *
     * @return array
     */
    public function current()
    {
        return $this->window;
    }

    /**
     * Get current key
     *
     * @return int
     */
    public function key()
    {
        return $this->count;
    }

    /**
     * Move to next element
     */
    public function next()
    {
        parent::next();

        ++$this->count;
        if (parent::valid()) {
            $this->advanceWindow();
        }
    }

    /**
     * Advances iterator, saving elements into the window
     * Keeps keys from iterable and removes first item if window grows too large
     */
    protected function advanceWindow()
    {
        $this->window[parent::key()] = parent::current();

        if (count($this->window) > $this->windowSize) {
            array_shift($this->window);
        }
    }
}
