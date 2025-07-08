<?php

namespace BenTools\CartesianProduct;

require_once __DIR__ . '/CartesianProduct.php';

/**
 * @template TKey
 * @template TValue
 * @param  array<TKey, iterable<TValue>> $set - A multidimensionnal array.
 * @return CartesianProduct<TKey, TValue>
 */
function cartesian_product(array $set)
{
    return new CartesianProduct($set);
}
