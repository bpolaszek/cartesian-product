<?php

namespace BenTools\CartesianProduct\Tests;

use function BenTools\CartesianProduct\cartesian_product;
use PHPUnit\Framework\TestCase;

class TestCartesianProduct extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCartesianProduct(array $cases, array $expected)
    {
        $result = cartesian_product($cases)->asArray();
        $this->assertArraySubset($expected, $result);
    }

    public function testEmptySet()
    {
        $set = [];
        $this->assertCount(0, iterator_to_array(cartesian_product($set)));
        $this->assertEquals([], cartesian_product($set)->asArray());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetWithEmptyArraySubset()
    {
        $set = [
            'fruits' => [
                'strawberry',
                'raspberry',
                'blueberry',
            ],
            'vegetables' => [],
            'drinks' => [
                'beer',
                'whiskey'
            ]
        ];
        foreach (cartesian_product($set) as $product) {
            continue;
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetWithInvalidSubset()
    {
        $set = [
            'fruits' => [
                'strawberry',
                'raspberry',
                'blueberry',
            ],
            'vegetables' => new \stdClass(),
            'drinks' => [
                'beer',
                'whiskey'
            ]
        ];
        foreach (cartesian_product($set) as $product) {
            continue;
        }
    }

    public function testCount()
    {
        $set = [
            ['a', 'b', 'c', 'd', 'e', 'f'],
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        ];
        $this->assertCount(60, cartesian_product($set));
        $this->assertCount(60, cartesian_product($set)); // Assert we can call it several times
    }

    public function testRetrieveCurrentCombination()
    {
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

        foreach (cartesian_product($set) as $product) {
            continue;
        }
        $this->assertNotNull($current);
        $this->assertInternalType('array', $current);
        $this->assertArrayHasKey('hair', $current);
        $this->assertArrayHasKey('skin', $current);
        $this->assertArrayNotHasKey('eyes', $current);
        $this->assertArrayNotHasKey('gender', $current);
    }

    public function dataProvider()
    {
        return [
            'shapesAndColors'      => $this->shapesAndColors(),
            'moreShapesThanColors' => $this->moreShapesThanColors(),
            'moreColorsThanShapes' => $this->moreColorsThanShapes(),
            'iCanHazClozures'      => $this->iCanHazClozures(),
        ];
    }

    private function shapesAndColors()
    {
        return [
            'cases'    => [
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

    private function moreShapesThanColors()
    {
        return [
            'cases'    => [
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

    private function moreColorsThanShapes()
    {
        return [
            'cases'    => [
                'color' => [
                    'blue',
                    'red',
                    'green'
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

    private function iCanHazClozures()
    {
        return [
            'cases'           => [
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
            'expected'        => [
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
}
