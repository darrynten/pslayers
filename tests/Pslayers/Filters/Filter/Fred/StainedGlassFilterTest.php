<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use Symfony\Component\Process\Exception\ProcessFailedException;

use DarrynTen\Pslayers\Filters\Filter\Fred\StainedGlassFilter;

class StainedGlassFiltersTest extends \PHPUnit_Framework_TestCase
{
    public function testNewStainedGlassFilter()
    {
        $filter = new StainedGlassFilter([
            'id' => 1,
        ]);

        $this->assertInstanceOf(StainedGlassFilter::class, $filter);
        $this->assertObjectHasAttribute('id', $filter);
    }

    public function testGetFilterArray()
    {
        $expected = [
            'id' => 1,
        ];

        $filter = new StainedGlassFilter([
            'id' => 1,
        ]);

        $this->assertEquals($expected, $filter->getFilterDetailsArray());
    }

    public function testGetStainedGlassFilterJson()
    {
        $expected = json_encode([
            'id' => 1,
        ]);

        $filter = new StainedGlassFilter([
            'id' => 1,
        ]);

        $this->assertEquals($expected, $filter->getFilterDetailsJson());
    }

    public function testRender()
    {
        $filter = new StainedGlassFilter([
            'id' => 1,
            'kind' => 'hexagon',
            'size' => 64,
            'offset' => 8,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 1,
            'rseed' => rand()
        ]);

        $image = new \Imagick;
        $image->newPseudoImage(10, 10, 'magick:logo');
        $image->setImageFormat('png');

        $tempFile = $image->writeImage('/tmp/in.png');

        $result = $filter->render('/tmp/in.png');
        $this->assertEquals('Reducing Colors:', trim($result));
    }

    public function testException()
    {
        $this->expectException(ProcessFailedException::class);

        $filter = new StainedGlassFilter([
            'id' => 1,
        ]);

        $result = $filter->render('');
    }
}
