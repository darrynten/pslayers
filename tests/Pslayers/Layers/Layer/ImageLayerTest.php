<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use PHPUnit_Framework_TestCase;
use DarrynTen\Pslayers\Layers\Layer\ImageLayer;

class ImageLayerTest extends PHPUnit_Framework_TestCase
{
    public function testImageLayer()
    {
        $layer = new ImageLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500,
            'imageUrl' => 'http://lorempixel.com/500/500/',
        ]);

        $this->assertInstanceOf(ImageLayer::class, $layer);
        $this->assertObjectHasAttribute('image', $layer);
    }

    public function testDefaultColour()
    {
        $layer = new ImageLayer([
            'id' => 1,
            'width' => 200,
            'height' => 200,
            'imageUrl' => 'http://lorempixel.com/200/200/',
        ]);

        $this->assertEquals('', $layer->image());

        $layer->image('text');
        $this->assertEquals('text', $layer->image());
    }

    public function testGetImageArray()
    {
        $expected = [
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'positionX' => 1,
            'positionY' => 1,
            'opacity' => 1.0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'image' => null,
        ];

        $layer = new ImageLayer([
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
            'image' => null,
        ]);

        $layer = new ImageLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
