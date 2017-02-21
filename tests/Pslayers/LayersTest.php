<?php

namespace DarrynTen\Pslayers\Tests;

use PHPUnit_Framework_TestCase;
use DarrynTen\Pslayers\Layers;

class LayersTest extends PHPUnit_Framework_TestCase
{
    public function testNewLayer()
    {
        $layers = new Layers([]);

        $this->assertInstanceOf(Layers::class, $layers);
    }
}
