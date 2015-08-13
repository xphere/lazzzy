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

use IteratorIterator;

/**
 * Class RewindableIterator
 *
 * Makes any iterator rewindable at the cost of memory
 *
 * @author Berny Cantos <be@rny.cc>
 */
class RewindableIterator extends IteratorIterator
{
    /**
     * @var bool
     *
     * Whether data must come from cache or not
     */
    private $fromCache;

    /**
     * @var array
     *
     * Cached data from iteration in the form [key, value]
     */
    private $cache;

    /**
     * Rewinds iterator
     */
    public function rewind()
    {
        if ($this->cache === null) {
            $this->cache = array();
            $this->fromCache = false;
            parent::rewind();
        } else {
            $this->fromCache = !empty($this->cache);
            reset($this->cache);
        }
    }

    /**
     * If iterator has more values
     *
     * @return bool
     */
    public function valid()
    {
        return $this->fromCache || parent::valid();
    }

    /**
     * Get current element
     *
     * Check in cache if needed or gets from inner iterator
     *
     * @return mixed
     */
    public function current()
    {
        if (!$this->fromCache) {
            return parent::current();
        }

        list(, $current) = current($this->cache);

        return $current;
    }

    /**
     * Get current key
     *
     * Check in cache if needed or gets from inner iterator
     *
     * @return mixed
     */
    public function key()
    {
        if (!$this->fromCache) {
            return parent::key();
        }

        list($key, ) = current($this->cache);

        return $key;
    }

    /**
     * Move to the next element
     *
     * Check in cache if needed or gets from inner iterator
     */
    public function next()
    {
        if ($this->fromCache && next($this->cache) !== false) {
            return;
        }

        if (parent::valid()) {
            $this->cache[] = array(parent::key(), parent::current());
        }

        $this->fromCache = false;
        parent::next();
    }
}
