<?php

namespace DarrynTen\Pslayers\Tests;

use PHPUnit_Framework_TestCase;
use DarrynTen\Pslayers\Layer;

class LayerTest extends PHPUnit_Framework_TestCase
{
    public function testNewLayer()
    {
        $layer = new Layer([
            'id' => 1
        ]);

        $this->assertInstanceOf(Layer::class, $layer);
    }

    public function testOpacity()
    {
        $layer = new Layer([
            'id' => 1
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
            'id' => 1
        ];

        $layer = new Layer([
            'id' => 1
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsArray());
    }

    public function testGetLayerJson()
    {
        $expected = json_encode([
            'id' => 1
        ]);

        $layer = new Layer([
            'id' => 1
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
