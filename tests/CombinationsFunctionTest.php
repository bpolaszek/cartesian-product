<?php

error_reporting(E_ALL);

use \BenTools\CartesianProduct\Tests\CountableIterator;

use function BenTools\CartesianProduct\combinations;


test('combinations', function (array $cases, array $expected) {
    $result = combinations($cases);
    expect($result->asArray())->toEqual($expected)
        ->and($result->asArray())->toEqual($expected);
})->with('data provider');

test('empty set', function () {
    $set = [];
    expect(iterator_to_array(combinations($set)))->toHaveCount(0)
        ->and(combinations($set)->asArray())->toEqual([]);
});

test('set with empty array subset', function () {
    $set = [
        'fruits' => [
            'strawberry',
            'raspberry',
            'blueberry',
        ],
        'vegetables' => [],
        'drinks' => [
            'beer',
            'whiskey',
        ],
    ];
    foreach (combinations($set) as $product) {
        continue;
    }
})->throws(InvalidArgumentException::class);

test('set with iterator subset', function () {
    $set = [
        'fruit' => [
            'strawberry',
            'raspberry',
        ],
        'vegetable' => new CountableIterator([
            'potato',
            function () {
                return 'carrot';
            },
        ]),
    ];

    $expected = [
        [
            'fruit' => 'strawberry',
            'vegetable' => 'potato',
        ],
        [
            'fruit' => 'strawberry',
            'vegetable' => 'carrot',
        ],
        [
            'fruit' => 'raspberry',
            'vegetable' => 'potato',
        ],
        [
            'fruit' => 'raspberry',
            'vegetable' => 'carrot',
        ],
    ];

    expect(combinations($set)->asArray())->toEqual($expected);
});

test('set with invalid subset', function () {
    $this->expectException(InvalidArgumentException::class);
    $set = [
        'fruits' => [
            'strawberry',
            'raspberry',
            'blueberry',
        ],
        'vegetables' => new stdClass(),
        'drinks' => [
            'beer',
            'whiskey',
        ],
    ];
    foreach (combinations($set) as $product) {
        continue;
    }
});

test('count', function () {
    $set = [
        ['a', 'b', 'c', 'd', 'e', 'f'],
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
    ];
    expect(combinations($set))->toHaveCount(60)
        ->and(combinations($set))->toHaveCount(60); // Assert we can call it several times
});

it('retrieves the current combination being generated', function () {
    $current = null;
    $set = [
        'hair' => [
            'blond',
            'dark',
        ],
        'skin' => [
            'white',
            'black',
        ],
        'eyes' => [
            'blue',
            function (array $combination) use (&$current) {
                if (null === $current) {
                    $current = $combination;
                }

                return 'green';
            },
        ],
        'gender' => [
            'male',
            'female',
        ],
    ];

    foreach (combinations($set) as $product) {
        continue;
    }
    expect($current)->not->toBeNull()
        ->and($current)->toBeArray()
        ->and($current)->toHaveKey('hair')
        ->and($current)->toHaveKey('skin')
        ->and($current)->not->toHaveKey('eyes')
        ->and($current)->not->toHaveKey('gender')
    ;
});

it('maps data with a function', function () {
    $set = [
        'vegetable' => [
            'potato',
        ],
        'color' => [
            'yellow',
        ],
    ];

    $combinations = combinations($set)->each(fn (array $combination) => array_map(strtoupper(...), $combination));
    expect([...$combinations])->toBe([
        [
            'vegetable' => 'POTATO',
            'color' => 'YELLOW',
        ],
    ]);
});

it('filters data with a function', function () {
    $set = [
        'vegetable' => [
            'potato',
            'carrot',
        ],
        'color' => [
            'yellow',
            'orange',
            'green',
        ],
    ];

    $combinations = combinations($set)->filter(fn (array $combination) => $combination['color'] !== 'green');
    expect([...$combinations])->toBe([
        [
            'vegetable' => 'potato',
            'color' => 'yellow',
        ],
        [
            'vegetable' => 'potato',
            'color' => 'orange',
        ],
        [
            'vegetable' => 'carrot',
            'color' => 'yellow',
        ],
        [
            'vegetable' => 'carrot',
            'color' => 'orange',
        ],
    ]);
});

dataset('data provider', function () {
    return [
        'shapesAndColors' => shapesAndColors(),
        'moreShapesThanColors' => moreShapesThanColors(),
        'moreColorsThanShapes' => moreColorsThanShapes(),
        'iCanHazClozures' => iCanHazClozures(),
    ];
});

function shapesAndColors(): array
{
    return [
        'cases' => [
            'color' => [
                'blue',
                'red',
                'green',
            ],
            'shape' => [
                'round',
                'square',
                'triangle',
            ],
        ],
        'expected' => [
            [
                'color' => 'blue',
                'shape' => 'round',
            ],
            [
                'color' => 'blue',
                'shape' => 'square',
            ],
            [
                'color' => 'blue',
                'shape' => 'triangle',
            ],
            [
                'color' => 'red',
                'shape' => 'round',
            ],
            [
                'color' => 'red',
                'shape' => 'square',
            ],
            [
                'color' => 'red',
                'shape' => 'triangle',
            ],
            [
                'color' => 'green',
                'shape' => 'round',
            ],
            [
                'color' => 'green',
                'shape' => 'square',
            ],
            [
                'color' => 'green',
                'shape' => 'triangle',
            ],
        ],
    ];
}

function moreShapesThanColors(): array
{
    return [
        'cases' => [
            'color' => [
                'blue',
                'red',
            ],
            'shape' => [
                'round',
                'square',
                'triangle',
            ],
        ],
        'expected' => [
            [
                'color' => 'blue',
                'shape' => 'round',
            ],
            [
                'color' => 'blue',
                'shape' => 'square',
            ],
            [
                'color' => 'blue',
                'shape' => 'triangle',
            ],
            [
                'color' => 'red',
                'shape' => 'round',
            ],
            [
                'color' => 'red',
                'shape' => 'square',
            ],
            [
                'color' => 'red',
                'shape' => 'triangle',
            ],
        ],
    ];
}

function moreColorsThanShapes(): array
{
    return [
        'cases' => [
            'color' => [
                'blue',
                'red',
                'green',
            ],
            'shape' => [
                'round',
                'square',
            ],
        ],
        'expected' => [
            [
                'color' => 'blue',
                'shape' => 'round',
            ],
            [
                'color' => 'blue',
                'shape' => 'square',
            ],
            [
                'color' => 'red',
                'shape' => 'round',
            ],
            [
                'color' => 'red',
                'shape' => 'square',
            ],
            [
                'color' => 'green',
                'shape' => 'round',
            ],
            [
                'color' => 'green',
                'shape' => 'square',
            ],
        ],
    ];
}

function iCanHazClozures(): array
{
    return [
        'cases' => [
            'color' => [
                'blue',
                function () {
                    return 'red';
                },
            ],
            'shape' => [
                'round',
                function () {
                    return 'square';
                },
            ],
        ],
        'expected' => [
            [
                'color' => 'blue',
                'shape' => 'round',
            ],
            [
                'color' => 'blue',
                'shape' => 'square',
            ],
            [
                'color' => 'red',
                'shape' => 'round',
            ],
            [
                'color' => 'red',
                'shape' => 'square',
            ],
        ],
    ];
}
