<?php

namespace BenTools\CartesianProduct\Tests;

use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * Class CountableIterator
 * @internal
 */
final class CountableIterator implements IteratorAggregate, Countable
{

    private $items = [];

    /**
     * CountableIterator constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }


    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function count()
    {
        return \count($this->items);
    }
}
