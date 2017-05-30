<?php

namespace BenTools\CartesianProduct;

class CartesianProduct implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $cases = [];

    /**
     * CartesianProduct constructor.
     * @param array $cases - A multidimensionnal array.
     */
    public function __construct(array $cases)
    {
        $this->cases = $cases;
    }

    /**
     * @return \Generator
     */
    public function getIterator()
    {
        if (!empty($this->cases)) {
            $keys = array_keys($this->cases);
            $key  = end($keys);
            if ($array = array_pop($this->cases)) {
                foreach (new self($this->cases) as $product) {
                    foreach ($array as $value) {
                        if ($value instanceof \Closure) {
                            yield $product + [$key => $value()];
                        } else {
                            yield $product + [$key => $value];
                        }
                    }
                }
            }
        } else {
            yield [];
        }
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return iterator_to_array($this);
    }
}
