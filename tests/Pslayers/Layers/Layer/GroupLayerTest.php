<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use DarrynTen\Pslayers\Layers\LayerCollection;
use DarrynTen\Pslayers\Layers\Layer\GroupLayer;
use DarrynTen\Pslayers\Layers\Layer\BlankLayer;

class GroupLayerTest extends \PHPUnit_Framework_TestCase
{
    public function testNewGroupLayer()
    {
        $layer = new GroupLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500
        ]);

        // Test the group
        $this->assertInstanceOf(GroupLayer::class, $layer);
        $this->assertObjectHasAttribute('group', $layer);
        $this->assertObjectHasAttribute('opacity', $layer);
        $this->assertInstanceOf(LayerCollection::class, $layer->group);
        $this->assertObjectHasAttribute('collection', $layer->group);
        $this->assertEmpty($layer->group->collection);

        // Add stuff to the group
        $newLayer = new BlankLayer([
            'id' => 2,
            'width' => 40,
            'height' => 40,
            'locationX' => 5,
            'locationY' => 5,
        ]);

        $zIndex = 1;
        $layer->group->addLayerToCollection($newLayer, $zIndex);
        $layer->group->addLayerToCollection($newLayer, 99);

        $this->assertNotEmpty($layer->group->collection);

        $collection = new LayerCollection;
        $collection->addLayerToCollection($layer, 0);

        $anotherLayer = new GroupLayer([
            'id' => 3,
            'width' => 200,
            'height' => 200,
            'group' => $collection
        ]);

    }

    public function testGetGroupLayerArray()
    {
        $expected = [
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'positionX' => 1,
            'positionY' => 1,
            'opacity' => 1.0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'group' => new LayerCollection,
        ];

        $layer = new GroupLayer([
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'opacity' => 1.0,
            'positionX' => 1,
            'positionY' => 1,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsArray());
    }

    public function testGetLayerJson()
    {
        $expected = json_encode([
            'id' => 1,
            'opacity' => 1,
            'width' => 0,
            'height' => 0,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'group' => new LayerCollection,
        ]);

        $layer = new GroupLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
