[![Latest Stable Version](https://poser.pugx.org/bentools/cartesian-product/v/stable)](https://packagist.org/packages/bentools/cartesian-product)
[![License](https://poser.pugx.org/bentools/cartesian-product/license)](https://packagist.org/packages/bentools/cartesian-product)
[![CI Workflow](https://github.com/bpolaszek/cartesian-product/actions/workflows/ci-workflow.yml/badge.svg)](https://github.com/bpolaszek/cartesian-product/actions/workflows/ci-workflow.yml)
[![Coverage](https://codecov.io/gh/bpolaszek/cartesian-product/branch/master/graph/badge.svg?token=3CF5QH0CKG)](https://codecov.io/gh/bpolaszek/cartesian-product)
[![Total Downloads](https://poser.pugx.org/bentools/cartesian-product/downloads)](https://packagist.org/packages/bentools/cartesian-product)

# Cartesian Product

A simple, low-memory footprint function to generate all combinations from a multi-dimensionnal array.

Usage
-------

```php
use function BenTools\CartesianProduct\combinations;

$data = [
    'hair' => [
        'blond',
        'black'
    ],
    'eyes' => [
        'blue',
        'green',
        function (array $combination) { // You can use closures to dynamically generate possibilities
            if ('black' === $combination['hair']) { // Then you have access to the current combination being built
                return 'brown';
            }
            return 'grey';
        }
    ]
];

foreach (combinations($data) as $combination) {
    printf('Hair: %s - Eyes: %s' . PHP_EOL, $combination['hair'], $combination['eyes']);
}
```

Output:
```
Hair: blond - Eyes: blue
Hair: blond - Eyes: green
Hair: blond - Eyes: grey
Hair: black - Eyes: blue
Hair: black - Eyes: green
Hair: black - Eyes: brown
```

Array output
------------

Instead of using `foreach` you can dump all possibilities into an array.

> [!WARNING]
> This will dump all combinations in memory, so be careful with large datasets.

```php
print_r(combinations($data)->asArray());
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
            [eyes] => grey
        )

    [3] => Array
        (
            [hair] => black
            [eyes] => blue
        )

    [4] => Array
        (
            [hair] => black
            [eyes] => green
        )

    [5] => Array
        (
            [hair] => black
            [eyes] => brown
        )

)
```

Combinations count
------------------

You can simply count how many combinations your data produce (this will not generate any combination):

```php
use function BenTools\CartesianProduct\combinations;

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
var_dump(count(combinations($data))); // 2 * 3 * 2 = 12
```

Filtering combinations
----------------------

You can filter combinations using the `filter` method. This is useful if you want to skip some combinations based on certain criteria:

```php
use function BenTools\CartesianProduct\combinations;

$data = [
    'hair' => [
        'blond',
        'black'
    ],
    'eyes' => [
        'blue',
        'green',
    ]
];

foreach (combinations($data)->filter(fn (array $combination) => 'green' !== $combination['eyes']) as $combination) {
    printf('Hair: %s - Eyes: %s' . PHP_EOL, $combination['hair'], $combination['eyes']);
}
```

Map output
----------

You can use the `each` method to transform each combination into a different format:

```php
use App\Entity\Book;

use function BenTools\CartesianProduct\combinations;

$books = [
    'author' => ['Isaac Asimov', 'Arthur C. Clarke'],
    'genre' => ['Science Fiction', 'Fantasy'],
]

foreach (combinations($books)->each(fn (array $combination) => Book::fromArray($combination)) as $book) {
    assert($book instanceof Book);
}
```

Installation
------------

PHP 8.2+ is required.
```
composer require bentools/cartesian-product
```

Performance test
----------------
The following example was executed on my Core i7 personnal computer with 8GB RAM.

```php
use function BenTools\CartesianProduct\combinations;

$data = array_fill(0, 10, array_fill(0, 5, 'foo'));

$start = microtime(true);
foreach (combinations($data) as $c => $combination) {
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
./vendor/bin/pest
```


Other implementations
---------------------

[th3n3rd/cartesian-product](https://github.com/th3n3rd/cartesian-product)

[patchranger/cartesian-iterator](https://github.com/PatchRanger/cartesian-iterator)

[Benchmark](https://github.com/PatchRanger/php-cartesian-benchmark)


See also
--------

[bentools/string-combinations](https://github.com/bpolaszek/string-combinations)

[bentools/iterable-functions](https://github.com/bpolaszek/php-iterable-functions)



Credits
-------
[Titus](https://stackoverflow.com/a/39174062) on StackOverflow - you really rock.
