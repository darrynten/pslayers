<?php

namespace DarrynTen\Pslayers\Tests;

use DarrynTen\Pslayers\Filters\Filter\BlankFilter;
use DarrynTen\Pslayers\Filters\FilterCollection;

class FilterCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function getTestImage()
    {
        $image = new \Imagick;
        $image->newPseudoImage(800, 200, 'fractal:');
        $image->setImageFormat('png');
        return $image;
    }

    public function testNewFilters()
    {
        $filters = new FilterCollection;

        $this->assertInstanceOf(FilterCollection::class, $filters);
    }

    public function testGetFiltersArray()
    {
        $filter = new BlankFilter([
            'id' => 1,
        ], $this->getTestImage());

        $expected = [
            'filters' => [
                $filter
            ]
        ];

        $filters = new FilterCollection;
        $filters->addFilterToCollection($filter, 0);

        $this->assertEquals($expected, $filters->getFiltersArray());
    }

    public function testGetFiltersJson()
    {
        $expected = json_encode([
            'filters' => [
                '1' => [
                    'id' => 1,
                ]
            ]
        ]);

        $filter = new BlankFilter([
            'id' => 1,
        ], $this->getTestImage());
        $filters = new FilterCollection;

        $filters->addFilterToCollection($filter, 1);

        $this->assertEquals($expected, $filters->getFiltersJson());
    }
}
