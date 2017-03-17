<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use DarrynTen\Pslayers\Layers\Layer\BlankLayer;

class BlankLayerTest extends \PHPUnit_Framework_TestCase
{
    public function testNewBlankLayer()
    {
        $layer = new BlankLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500
        ]);

        $this->assertInstanceOf(BlankLayer::class, $layer);
        $this->assertObjectHasAttribute('id', $layer);
        $this->assertObjectHasAttribute('width', $layer);
        $this->assertObjectHasAttribute('height', $layer);
        $this->assertObjectHasAttribute('positionX', $layer);
        $this->assertObjectHasAttribute('positionY', $layer);
        $this->assertObjectHasAttribute('opacity', $layer);
        $this->assertObjectHasAttribute('composite', $layer);

        $this->assertObjectHasAttribute('canvas', $layer);
        $this->assertInstanceOf(Imagick::class, $layer->canvas);

        // TODO
        $layer->render();
    }

    public function testOpacity()
    {
        $layer = new BlankLayer([
            'id' => 1,
            'width' => 200,
            'height' => 2000
        ]);

        $this->assertEquals(1.0, $layer->opacity());

        $layer->opacity(0.4);
        $this->assertEquals(0.4, $layer->opacity());

        $layer->opacity(0.0);
        $this->assertEquals(0.0, $layer->opacity());

        $layer->opacity(0);
        $this->assertEquals(0.0, $layer->opacity());

        $layer->opacity(1);
        $this->assertEquals(1.0, $layer->opacity());
    }

    public function testComposite()
    {
        $layer = new BlankLayer([
            'id' => 1,
            'width' => 200,
            'height' => 2000
        ]);

        $this->assertEquals(Imagick::COMPOSITE_DEFAULT, $layer->composite());

        $layer->composite(Imagick::COMPOSITE_BLEND);
        $this->assertEquals(Imagick::COMPOSITE_BLEND, $layer->composite());
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
            'composite' => Imagick::COMPOSITE_DEFAULT
        ];

        $layer = new BlankLayer([
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'opacity' => 1.0,
            'positionX' => 1,
            'positionY' => 1,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsArray());
    }

    public function testGetBlankLayerJson()
    {
        $expected = json_encode([
            'id' => 1,
            'opacity' => 1,
            'width' => 0,
            'height' => 0,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_DEFAULT
        ]);

        $layer = new BlankLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
