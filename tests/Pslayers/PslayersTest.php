<?php

namespace DarrynTen\Pslayers\Tests\Pslayers;

use PHPUnit_Framework_TestCase;

use DarrynTen\Pslayers\Pslayers;
use DarrynTen\Pslayers\Validation;

class PslayersTest extends PHPUnit_Framework_TestCase
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
    }

    public function testValidation()
    {
        $this->assertEquals(true, Validation::isValidImageType('jpg'));
        $this->assertFalse(Validation::isValidImageType('doc'));
    }
}
