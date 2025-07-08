<?php

namespace BenTools\CartesianProduct\Tests;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Class CountableIterator
 * @internal
 */
final class CountableIterator implements IteratorAggregate, Countable
{

    private array $items = [];

    /**
     * CountableIterator constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }


    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }
}
