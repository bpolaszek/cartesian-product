<?php

namespace BenTools\CartesianProduct;

require_once __DIR__ . '/CartesianProduct.php';

/**
 * @param  array $set - A multidimensionnal array.
 * @return CartesianProduct
 */
function cartesian_product(array $set)
{
    return new CartesianProduct($set);
}
