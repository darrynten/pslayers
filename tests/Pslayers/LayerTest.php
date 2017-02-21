<?php

namespace DarrynTen\Pslayers\Tests;

use PHPUnit_Framework_TestCase;
use DarrynTen\Pslayers\Layer;

class LayerTest extends PHPUnit_Framework_TestCase
{
    public function testNewLayer()
    {
        $layer = new Layer([]);

        $this->assertInstanceOf(Layer::class, $layer);
    }
}
