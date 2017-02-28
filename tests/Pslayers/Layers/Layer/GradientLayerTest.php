<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use DarrynTen\Pslayers\Layers\Layer\GradientLayer;

class GradientLayerTest extends \PHPUnit_Framework_TestCase
{
    public function testGradientLayer()
    {
        $layer = new GradientLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500,
        ]);

        $this->assertInstanceOf(GradientLayer::class, $layer);
        $this->assertObjectHasAttribute('startColour', $layer);
        $this->assertObjectHasAttribute('endColour', $layer);
    }

    public function testGradientColours()
    {
        $layer = new GradientLayer([
            'id' => 1,
            'width' => 200,
            'height' => 2000
        ]);

        $this->assertEquals('', $layer->startColour());
        $this->assertEquals('', $layer->endColour());

        $layer->startColour('text');
        $layer->endColour('text2');

        $this->assertEquals('text', $layer->startColour());
        $this->assertEquals('text2', $layer->endColour());
    }

    public function testGetGradientLayerArray()
    {
        $expected = [
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'positionX' => 1,
            'positionY' => 1,
            'opacity' => 1.0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'startColour' => null,
            'endColour' => null,
        ];

        $layer = new GradientLayer([
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
            'startColour' => null,
            'endColour' => null,
        ]);

        $layer = new GradientLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
