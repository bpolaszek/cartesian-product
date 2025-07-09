<?php

namespace BenTools\CartesianProduct;

use Closure;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

use function array_keys;
use function array_map;
use function array_pop;
use function array_product;
use function count;
use function end;
use function is_array;
use function iterator_to_array;

/**
 * @internal - use the function `combinations()` instead.
 * @template TKey
 * @template TValue
 * @implements IteratorAggregate<array<TKey, TValue>>
 */
final class CartesianProduct implements IteratorAggregate, Countable
{
    /**
     * @var array<TKey, iterable<TValue>>
     */
    private array $set;
    private bool $isRecursiveStep = false;
    private int $count;
    private ?Closure $mapCallback = null;

    /**
     * @param array<TKey, iterable<TValue>> $set
     */
    public function __construct(array $set)
    {
        $this->set = $set;
    }

    public function each(callable $callback): self
    {
        $clone = clone $this;
        $clone->mapCallback = Closure::fromCallable($callback);

        return $clone;
    }

    /**
     * @return Traversable<array<TKey, TValue>>
     */
    public function getIterator(): Traversable
    {
        if ([] === $this->set) {
            if (true === $this->isRecursiveStep) {
                yield [];
            }

            return;
        }

        $set = $this->set;
        $keys = array_keys($set);
        $last = end($keys);
        $subset = array_pop($set);
        $this->validate($subset, $last);
        foreach (self::subset($set) as $product) {
            foreach ($subset as $value) {
                $combination = $product + [$last => ($value instanceof Closure ? $value($product) : $value)];
                yield $this->mapCallback ? ($this->mapCallback)($combination) : $combination;
            }
        }
    }

    /**
     * @return array<array<TKey, TValue>>
     */
    public function asArray(): array
    {
        return iterator_to_array($this);
    }

    public function count(): int
    {
        return $this->count ??= (int) array_product(
            array_map(
                function ($subset, $key) {
                    $this->validate($subset, $key);
                    return count($subset);
                },
                $this->set,
                array_keys($this->set)
            )
        );
    }

    /**
     * @param mixed $subset
     * @param TKey $key
     */
    private function validate(mixed $subset, $key): void
    {
        // Validate array subset
        if (is_array($subset) && !empty($subset)) {
            return;
        }

        // Validate iterator subset
        if ($subset instanceof Traversable && $subset instanceof Countable && count($subset) > 0) {
            return;
        }

        throw new InvalidArgumentException(\sprintf('Key "%s" should return a non-empty iterable', $key));
    }

    /**
     * @param array<TKey, iterable<TValue>> $subset
     * @return CartesianProduct<TKey, TValue>
     */
    private static function subset(array $subset): self
    {
        $product = new self($subset);
        $product->isRecursiveStep = true;

        return $product;
    }
}
