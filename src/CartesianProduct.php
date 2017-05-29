<?php

namespace BenTools\CartesianProduct;

class CartesianProduct implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $cases = [];

    /**
     * @var bool
     */
    private $resolveClosures = false;

    /**
     * CartesianProduct constructor.
     * @param array $cases - A multidimensionnal array.
     * @param bool $resolveClosures - Wether or not we should resolve closures.
     */
    public function __construct(array $cases, $resolveClosures = false)
    {
        $this->cases           = $cases;
        $this->resolveClosures = (bool) $resolveClosures;
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
                foreach (new self($this->cases, $this->resolveClosures) as $product) {
                    foreach ($array as $value) {
                        if (true === $this->resolveClosures && $value instanceof \Closure) {
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
