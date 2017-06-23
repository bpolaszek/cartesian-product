[![Latest Stable Version](https://poser.pugx.org/bentools/cartesian-product/v/stable)](https://packagist.org/packages/bentools/cartesian-product)
[![License](https://poser.pugx.org/bentools/cartesian-product/license)](https://packagist.org/packages/bentools/cartesian-product)
[![Build Status](https://img.shields.io/travis/bpolaszek/cartesian-product/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/cartesian-product)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/cartesian-product/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/cartesian-product?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/cartesian-product.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/cartesian-product)
[![Total Downloads](https://poser.pugx.org/bentools/cartesian-product/downloads)](https://packagist.org/packages/bentools/cartesian-product)

# Cartesian Product

A simple, low-memory footprint function to generate all combinations from a multi-dimensionnal array.

Usage
-------

```php
require_once __DIR__ . '/vendor/autoload.php';

use function BenTools\CartesianProduct\cartesian_product;

$data = [
    'hair' => [
        'blond',
        'red'
    ],
    'eyes' => [
        'blue',
        'green',
        function () {
            return 'brown'; // You can use closures to dynamically generate possibilities
        }
    ]
];

foreach (cartesian_product($data) as $combination) {
    printf('Hair: %s - Eyes: %s' . PHP_EOL, $combination['hair'], $combination['eyes']);
}
```

Output:
```
Hair: blond - Eyes: blue
Hair: blond - Eyes: green
Hair: blond - Eyes: brown
Hair: red - Eyes: blue
Hair: red - Eyes: green
Hair: red - Eyes: brown
```

Array output
------------

Instead of using `foreach` you can dump all possibilities into an array.

```php
print_r(cartesian_product($data)->asArray());
```

Output:
```php
Array
(
    [0] => Array
        (
            [hair] => blond
            [eyes] => blue
        )

    [1] => Array
        (
            [hair] => blond
            [eyes] => green
        )

    [2] => Array
        (
            [hair] => blond
            [eyes] => brown
        )

    [3] => Array
        (
            [hair] => red
            [eyes] => blue
        )

    [4] => Array
        (
            [hair] => red
            [eyes] => green
        )

    [5] => Array
        (
            [hair] => red
            [eyes] => brown
        )

)
```


Combinations count
------------------

You can simply count how many combinations your data produce:

```php
require_once __DIR__ . '/vendor/autoload.php';

use function BenTools\CartesianProduct\cartesian_product;

$data = [
    'hair' => [
        'blond',
        'red',
    ],
    'eyes' => [
        'blue',
        'green',
        'brown',
    ],
    'gender' => [
        'male',
        'female',
    ]
];
var_dump(count(cartesian_product($data))); // 2 * 3 * 2 = 12
```


Installation
------------

PHP 5.6+ is required.
```
composer require bentools/cartesian-product
```

Performance test
----------------
The following example was executed on my Core i7 personnal computer with 8GB RAM.

```php
require_once __DIR__ . '/vendor/autoload.php';
use function BenTools\CartesianProduct\cartesian_product;

$data = array_fill(0, 10, array_fill(0, 5, 'foo'));

$start = microtime(true);
foreach (cartesian_product($data) as $c => $combination) {
    continue;
}
$end = microtime(true);

printf(
    'Generated %d combinations in %ss - Memory usage: %sMB / Peak usage: %sMB',
    ++$c,
    round($end - $start, 3),
    round(memory_get_usage() / 1024 / 1024),
    round(memory_get_peak_usage() / 1024 / 1024)
);
```

Output:
> Generated 9765625 combinations in 1.61s - Memory usage: 0MB / Peak usage: 1MB

Unit tests
----------
```
./vendor/bin/phpunit
```

See also
--------

[bentools/string-combinations](https://github.com/bpolaszek/string-combinations)

[bentools/iterable-functions](https://github.com/bpolaszek/php-iterable-functions)

Credits
-------
[Titus](https://stackoverflow.com/a/39174062) on StackOverflow - you really rock.