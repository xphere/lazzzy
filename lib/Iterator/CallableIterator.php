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

use Iterator;

class CallableIterator implements Iterator
{
    /**
     * @var \Generator|null|false
     */
    private $generator;

    /**
     * @var callable
     */
    private $callable;

    /**
     * @var integer index
     */
    private $index;

    public function __construct(Callable $callable)
    {
        $this->callable = $callable;
    }

    public function rewind()
    {
        if ($this->index !== null) {
            throw new \Exception(
                'Cannot rewind a callable that was already run'
            );
        }

        $this->index = 0;
    }

    public function valid()
    {
        return $this->generator ? $this->generator->valid() : true;
    }

    public function current()
    {
        if ($this->generator) {
            return $this->generator->current();
        }

        $callable = $this->callable;
        $result = $callable();

        if (!$this->generator && $this->generator !== false) {
            $this->generator = $result instanceof \Generator ? $result : false;

            if ($this->generator) {
                return $this->generator->current();
            }
        }

        return $result;
    }

    public function key()
    {
        return $this->generator ? $this->generator->key() : $this->index++;
    }

    public function next()
    {
        if ($this->generator) {
            $this->generator->next();
        }
    }
}
