<?php

namespace DarrynTen\Pslayers\Tests\Pslayers;

use DarrynTen\Pslayers\Pslayers;
use DarrynTen\Pslayers\Validation;
use DarrynTen\Pslayers\Layers\Layer\BlankLayer;
use DarrynTen\Pslayers\Layers\LayerCollection;

class PslayersTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $config = [
            'id' => 11,
            'width' => 800,
            'height' => 300,
        ];

        $instance = new Pslayers($config);
        $this->assertInstanceOf(Pslayers::class, $instance);

        $config = [
            'width' => 800,
            'height' => 300,
        ];

        $instance = new Pslayers($config);
        $this->assertInstanceOf(Pslayers::class, $instance);
        $this->assertObjectHasAttribute('config', $instance);
        $this->assertObjectHasAttribute('layers', $instance);
        $this->assertObjectHasAttribute('imagick', $instance);

        $newLayer = new BlankLayer([
            'id' => 'aaa',
            'width' => 20,
            'height' => 20
        ]);

        $instance->addLayer($newLayer, 1);
        $this->assertInstanceOf(LayerCollection::class, $instance->layers);
        $this->assertNotEmpty($instance->layers);
        $this->assertNotEmpty($instance->layers->collection);
        $this->assertArrayNotHasKey(0, $instance->layers->collection);
        $this->assertNotEmpty($instance->layers->collection[1]);
        $this->assertEquals('aaa', $instance->layers->collection[1]->id);
        $this->assertArrayNotHasKey(2, $instance->layers->collection);
    }

    public function testValidation()
    {
        $this->assertEquals(true, Validation::isValidImageType('jpg'));
        $this->assertFalse(Validation::isValidImageType('doc'));
    }

    public function testMasterRender()
    {
        $config = [
            'id' => 11,
            'width' => 800,
            'height' => 300,
        ];

        $instance = new Pslayers($config);
        $instance->render();
    }
}
