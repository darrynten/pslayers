<?php

namespace DarrynTen\Pslayers\Tests;

use PHPUnit_Framework_TestCase;
use DarrynTen\Pslayers\Layers\Layer\TextLayer;

class TextLayerTest extends PHPUnit_Framework_TestCase
{
    public function testNewTextLayer()
    {
        $layer = new TextLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500,
        ]);

        $this->assertInstanceOf(TextLayer::class, $layer);
    }

    public function testDefaultText()
    {
        $layer = new TextLayer([
            'id' => 1,
            'width' => 200,
            'height' => 2000
        ]);

        $this->assertEquals('', $layer->text());

        $layer->text('text');
        $this->assertEquals('text', $layer->text());

    }

    public function testGetTextLayerArray()
    {
        $expected = [
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'positionX' => 1,
            'positionY' => 1,
            'opacity' => 1.0,
            'text' => '',
        ];

        $layer = new TextLayer([
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
            'text' => '',
        ]);

        $layer = new TextLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
