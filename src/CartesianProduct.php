<?php

namespace BenTools\CartesianProduct;

use Countable;
use IteratorAggregate;

class CartesianProduct implements IteratorAggregate, Countable
{
    /**
     * @var array
     */
    private $set = [];

    /**
     * @var bool
     */
    private $isRecursiveStep = false;

    /**
     * @var int
     */
    private $count;

    /**
     * CartesianProduct constructor.
     * @param array $set - A multidimensionnal array.
     */
    public function __construct(array $set)
    {
        $this->set = $set;
    }

    /**
     * @return \Generator
     */
    public function getIterator()
    {
        if (!empty($this->set)) {
            $keys = array_keys($this->set);
            $key = end($keys);
            $subset = array_pop($this->set);
            $this->validate($subset, $key);
            foreach (self::subset($this->set) as $product) {
                foreach ($subset as $value) {
                    if ($value instanceof \Closure) {
                        yield $product + [$key => $value($product)];
                    } else {
                        yield $product + [$key => $value];
                    }
                }
            }
        } else {
            if (true === $this->isRecursiveStep) {
                yield [];
            }
        }
    }

    /**
     * @param $subset
     * @param $key
     */
    private function validate($subset, $key)
    {
        if (!is_array($subset) || empty($subset)) {
            throw new \InvalidArgumentException(sprintf('Key "%s" should return a non-empty array', $key));
        }
    }

    /**
     * @param array $subset
     * @return CartesianProduct
     */
    private static function subset(array $subset)
    {
        $product = new self($subset);
        $product->isRecursiveStep = true;
        return $product;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return iterator_to_array($this);
    }

    /**
     * @return int
     */
    public function count()
    {
        if (null === $this->count) {
            $this->count = (int) array_product(array_map(function ($subset, $key) {
                $this->validate($subset, $key);
                return count($subset);
            }, $this->set, array_keys($this->set)));
        }
        return $this->count;
    }
}
