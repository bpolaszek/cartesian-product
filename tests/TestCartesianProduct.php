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
