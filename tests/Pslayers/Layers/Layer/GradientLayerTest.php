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
            'startColour' => '#FFF',
            'endColour' => '#000',
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
            'height' => 2000,
            'startColour' => '#000',
            'endColour' => '#FFF'
        ]);

        $this->assertEquals('#000', $layer->startColour());
        $this->assertEquals('#FFF', $layer->endColour());

        $layer->startColour('#000');
        $layer->endColour('#FFF');

        $this->assertEquals('#000', $layer->startColour());
        $this->assertEquals('#FFF', $layer->endColour());
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
            'startColour' => '#FFF',
            'endColour' => '#000',
        ];

        $layer = new GradientLayer([
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'opacity' => 1.0,
            'positionX' => 1,
            'positionY' => 1,
            'startColour' => '#FFF',
            'endColour' => '#000',
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
            'startColour' => '#FFF',
            'endColour' => '#000',
        ]);

        $layer = new GradientLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
            'startColour' => '#FFF',
            'endColour' => '#000',
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
