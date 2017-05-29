<?php

namespace BenTools\CartesianProduct;

require_once __DIR__ . '/CartesianProduct.php';

/**
 * @param array $cases - A multidimensionnal array.
 * @param bool $resolveClosures - Wether or not we should resolve closures.
 * @return CartesianProduct
 */
function cartesian_product(array $cases, $resolveClosures = false)
{
    return new CartesianProduct($cases, $resolveClosures);
}
