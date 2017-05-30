<?php

namespace BenTools\CartesianProduct;

require_once __DIR__ . '/CartesianProduct.php';

/**
 * @param array $cases - A multidimensionnal array.
 * @return CartesianProduct
 */
function cartesian_product(array $cases)
{
    return new CartesianProduct($cases);
}
