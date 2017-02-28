<?php

namespace DarrynTen\Pslayers\Tests\Pslayers\Exceptions;

use DarrynTen\Pslayers\Exceptions\PslayersException;
use DarrynTen\Pslayers\Pslayers;
use DarrynTen\Pslayers\Layers\Layer\BlankLayer;
use DarrynTen\Pslayers\Filters\Filter\BlankFilter;

class PslayersExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testJsonException()
    {
        $this->expectException(PslayersException::class);

        throw new PslayersException(
            json_encode(
                [
                    'errors' => [
                        'code' => 1,
                    ],
                    'status' => 10022,
                    'title' => 'Error',
                    'detail' => 'Error Details',
                ]
            )
        );
    }

    public function testMissingWidthPslayers()
    {
        $this->expectException(PslayersException::class);

        $config = [];
        $instance = new Pslayers($config);
    }

    public function testMissingHeightPslayers()
    {
        $this->expectException(PslayersException::class);

        $config = ['width' => 10];
        $instance = new Pslayers($config);
    }

    public function testMissingLayerId()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlankLayer([]);
    }

    public function testMissingLayerWidth()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlankLayer([
            'id' => 1,
        ]);
    }

    public function testMissingLayerHeight()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlankLayer([
            'id' => 1,
            'width' => 100,
        ]);
    }

    public function testMissingFilterId()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlankFilter([]);
    }
}
