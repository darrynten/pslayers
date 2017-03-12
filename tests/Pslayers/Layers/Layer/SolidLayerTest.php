<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use DarrynTen\Pslayers\Layers\Layer\SolidLayer;

class SolidLayerTest extends \PHPUnit_Framework_TestCase
{
    public function testSolidLayer()
    {
        $layer = new SolidLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500,
            'colour' => '#94F',
        ]);

        $this->assertInstanceOf(SolidLayer::class, $layer);
        $this->assertObjectHasAttribute('colour', $layer);
    }

    public function testDefaultColour()
    {
        $layer = new SolidLayer([
            'id' => 1,
            'width' => 200,
            'height' => 200,
            'colour' => '#04d93e',
        ]);

        $layer->colour('#000');
        $this->assertEquals('#000', $layer->colour());

        // Americanism
        $layer->color('#FFFFFF');

        $this->assertEquals('#FFFFFF', $layer->color());
    }

    public function testGetSolidLayerArray()
    {
        $expected = [
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'positionX' => 1,
            'positionY' => 1,
            'opacity' => 1.0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'colour' => '#04d93e',
        ];

        $layer = new SolidLayer([
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'opacity' => 1.0,
            'positionX' => 1,
            'positionY' => 1,
            'colour' => '#04d93e',
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
            'colour' => '#F93',
        ]);

        $layer = new SolidLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
            'colour' => '#F93',
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
