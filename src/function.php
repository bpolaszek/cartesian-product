<?php

namespace BenTools\CartesianProduct;

/**
 * @template TKey
 * @template TValue
 * @param  array<TKey, iterable<TValue>> $set - A multidimensionnal array.
 * @return CartesianProduct<TKey, TValue>
 */
function combinations(array $set): CartesianProduct
{
    return new CartesianProduct($set);
}
