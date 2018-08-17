<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use Symfony\Component\Process\Exception\ProcessFailedException;

use DarrynTen\Pslayers\Filters\Filter\Fred\StainedGlass\StainedGlassFilter;
use DarrynTen\Pslayers\Exceptions\PslayersException;

class StainedGlassFilterTest extends \PHPUnit\Framework\TestCase
{
    public function getTestImage()
    {
        $image = new \Imagick;
        $image->newPseudoImage(800, 200, 'pattern:BRICKS');
        $image->setImageFormat('png');
        return $image;
    }

    public function testNewStainedGlassFilter()
    {
        $filter = new StainedGlassFilter([
            'id' => 1,
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => rand()
        ], $this->getTestImage());

        $this->assertInstanceOf(StainedGlassFilter::class, $filter);
        $this->assertObjectHasAttribute('id', $filter);
    }

    public function testGetFilterArray()
    {
        $expected = [
            'id' => 1,
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => 1,
        ];

        $filter = new StainedGlassFilter([
            'id' => 1,
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => 1,
        ], $this->getTestImage());

        $this->assertEquals($expected, $filter->getFilterDetailsArray());
    }

    public function testGetStainedGlassFilterJson()
    {
        $expected = json_encode([
            'id' => 1,
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => 2,
        ]);

        $filter = new StainedGlassFilter([
            'id' => 1,
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => 2,
        ], $this->getTestImage());

        $this->assertEquals($expected, $filter->getFilterDetailsJson());
    }

    public function testRender()
    {
        $image = new \Imagick;
        $image->newPseudoImage(800, 200, 'pattern:BRICKS');
        $image->setImageFormat('png');

        $filter = new StainedGlassFilter([
            'id' => 1,
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => rand()
        ]);

        $filter->setImage($image);

        // $result = $filter->render();
    }

    public function testWrongKindException()
    {
        $this->expectException(PslayersException::class);

        $filter = new StainedGlassFilter([
            'id' => 1,
            'kind' => 'xxx',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => rand()
        ], $this->getTestImage());
    }

    public function testMissingPropertyException()
    {
        $this->expectException(PslayersException::class);

        $filter = new StainedGlassFilter([
            'id' => 1,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => rand()
        ], $this->getTestImage());
    }

    public function testProcessedException()
    {
        $image = new \Imagick;
        $image->newPseudoImage(800, 200, 'pattern:BRICKS');
        $image->setImageFormat('png');

        $this->expectException(ProcessFailedException::class);

        $filter = new StainedGlassFilter([
            'id' => 1,
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 8,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => rand()
        ]);

        $filter->setImage($this->getTestImage());

        // We're going to get rid of the command to throw the exception
        $reflection = new \ReflectionClass($filter);
        $reflection_property = $reflection->getProperty('command');
        $reflection_property->setAccessible(true);

        $reflection_property->setValue($filter, 'xxxxxxx');

        $result = $filter->render();
    }
}
