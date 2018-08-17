<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use DarrynTen\Pslayers\Filters\Filter\BlankFilter;
use DarrynTen\Pslayers\Exceptions\PslayersException;

class BlankFilterTest extends \PHPUnit\Framework\TestCase
{
    public function getTestImage()
    {
        $image = new \Imagick;
        $image->newPseudoImage(800, 200, 'fractal:');
        $image->setImageFormat('png');
        return $image;
    }

    public function testNewBlankFilter()
    {
        $filter = new BlankFilter([
            'id' => 1,
        ], $this->getTestImage());

        $this->assertInstanceOf(BlankFilter::class, $filter);
        $this->assertObjectHasAttribute('id', $filter);
    }

    public function testGetFilterArray()
    {
        $expected = [
            'id' => 1,
        ];

        $filter = new BlankFilter([
            'id' => 1,
        ], $this->getTestImage());

        $this->assertEquals($expected, $filter->getFilterDetailsArray());
    }

    public function testGetBlankFilterJson()
    {
        $expected = json_encode([
            'id' => 1,
        ]);

        $filter = new BlankFilter([
            'id' => 1,
        ], $this->getTestImage());

        $this->assertEquals($expected, $filter->getFilterDetailsJson());
    }
}
