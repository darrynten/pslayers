<?php

namespace DarrynTen\Pslayers\Tests;

use PHPUnit_Framework_TestCase;
use DarrynTen\Pslayers\Layer;
use DarrynTen\Pslayers\Layers;

class LayersTest extends PHPUnit_Framework_TestCase
{
    public function testNewLayers()
    {
        $layers = new Layers;

        $this->assertInstanceOf(Layers::class, $layers);
    }

    public function testGetLayersArray()
    {
        $expected = [
            'layers' => [
                [
                    'id' => 1
                ]
            ]
        ];

        $layer = new Layer(['id' => 1]);
        $layers = new Layers;

        $layers->addLayerToCollection($layer);

        $this->assertEquals($expected, $layers->getLayersArray());
    }

    public function testGetLayersJson()
    {
        $expected = json_encode([
            'layers' => [
                [
                    'id' => 1
                ]
            ]
        ]);

        $layer = new Layer(['id' => 1]);
        $layers = new Layers;

        $layers->addLayerToCollection($layer);

        $this->assertEquals($expected, $layers->getLayersJson());
    }
}
