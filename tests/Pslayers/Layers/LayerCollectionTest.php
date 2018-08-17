<?php

namespace DarrynTen\Pslayers\Tests;

use DarrynTen\Pslayers\Layers\Layer\BlankLayer;
use DarrynTen\Pslayers\Layers\LayerCollection;
use DarrynTen\Pslayers\Filters\Filter\BlankFilter;

class LayerCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testNewLayers()
    {
        $layers = new LayerCollection;

        $this->assertInstanceOf(LayerCollection::class, $layers);
    }

    public function testGetLayersArray()
    {
        $layer = new BlankLayer([
            'id' => 1,
            'opacity' => 1,
            'width' => 111,
            'height' => 111,
        ]);

        $expected = [
            'layers' => [
                $layer
            ]
        ];

        $layers = new LayerCollection;
        $layers->addLayerToCollection($layer, 0);

        $this->assertEquals($expected, $layers->getLayersArray());
    }

    public function testGetLayersJson()
    {
        $expected = json_encode([
            'layers' => [
                '1' => [
                    'id' => 1,
                    'width' => 1,
                    'height' => 1,
                    'positionX' => 0,
                    'positionY' => 0,
                    'opacity' => 0.4,
                    'composite' => \Imagick::COMPOSITE_DEFAULT,
                    'filters' => [ 'collection' => [] ],
                    'canvas' => new \stdClass,
                ]
            ]
        ]);

        $layer = new BlankLayer([
            'id' => 1,
            'opacity' => 0.4,
            'width' => 1,
            'height' => 1,
        ]);
        $layers = new LayerCollection;

        $layers->addLayerToCollection($layer, 1);

        $this->assertEquals($expected, $layers->getLayersJson());
    }
}
