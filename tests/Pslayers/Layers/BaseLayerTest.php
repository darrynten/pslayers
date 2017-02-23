<?php

namespace DarrynTen\Pslayers\Tests;

use PHPUnit_Framework_TestCase;
use DarrynTen\Pslayers\Layers\BaseLayer;

class LayerTest extends PHPUnit_Framework_TestCase
{
    public function testNewLayer()
    {
        $layer = new BaseLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500
        ]);

        $this->assertInstanceOf(BaseLayer::class, $layer);
    }

    public function testOpacity()
    {
        $layer = new BaseLayer([
            'id' => 1,
            'width' => 200,
            'height' => 2000
        ]);

        $this->assertEquals(1.0, $layer->opacity());

        $layer->opacity(0.4);
        $this->assertEquals(0.4, $layer->opacity());

        $layer->opacity(-0.4);
        $this->assertEquals(0.0, $layer->opacity());

        $layer->opacity(290);
        $this->assertEquals(1.0, $layer->opacity());

        $layer->opacity(0);
        $this->assertEquals(0.0, $layer->opacity());

        $layer->opacity(1);
        $this->assertEquals(1.0, $layer->opacity());
    }

    public function testGetLayerArray()
    {
        $expected = [
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'positionX' => 1,
            'positionY' => 1,
            'opacity' => 1.0,
        ];

        $layer = new BaseLayer([
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
        ]);

        $layer = new BaseLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
