<?php

namespace BenTools\CartesianProduct;

class CartesianProduct implements \IteratorAggregate
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
                        yield $product + [$key => $value()];
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
}
