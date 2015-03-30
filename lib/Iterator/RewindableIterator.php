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

use IteratorIterator;

class RewindableIterator extends IteratorIterator
{
    private $fromCache;
    private $cache;

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

    public function valid()
    {
        return $this->fromCache || parent::valid();
    }

    public function current()
    {
        if (!$this->fromCache) {
            return parent::current();
        }

        list(, $current) = current($this->cache);

        return $current;
    }

    public function key()
    {
        if (!$this->fromCache) {
            return parent::key();
        }

        list($key, ) = current($this->cache);

        return $key;
    }

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
