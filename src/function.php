<?php

namespace BenTools\CartesianProduct;

use function trigger_error;

use const E_USER_DEPRECATED;

require_once __DIR__ . '/CartesianProduct.php';

/**
 * @template TKey
 * @template TValue
 * @param  array<TKey, iterable<TValue>> $set - A multidimensionnal array.
 * @return CartesianProduct<TKey, TValue>
 */
function cartesian_product(array $set): CartesianProduct
{
    trigger_error(sprintf(
        'The function %s() is deprecated since 1.5 and will be removed in 2.0. Use %s() instead.',
        __FUNCTION__,
        'BenTools\CartesianProduct\combinations'
    ), E_USER_DEPRECATED);

    return new CartesianProduct($set);
}

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
