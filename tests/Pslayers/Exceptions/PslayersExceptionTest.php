<?php

namespace DarrynTen\Pslayers\Tests\Pslayers\Exceptions;

use DarrynTen\Pslayers\Exceptions\PslayersException;
use DarrynTen\Pslayers\Pslayers;
use DarrynTen\Pslayers\Layers\Layer\BlankLayer;
use DarrynTen\Pslayers\Layers\Layer\SolidLayer;
use DarrynTen\Pslayers\Layers\Layer\PatternLayer;
use DarrynTen\Pslayers\Layers\Layer\RadialGradientLayer;
use DarrynTen\Pslayers\Layers\Layer\GradientLayer;
use DarrynTen\Pslayers\Filters\Filter\BlankFilter;
use DarrynTen\Pslayers\Filters\Filter\Standard\Blur\BlurFilter;
use DarrynTen\Pslayers\Validators\ColourValidator;

class PslayersExceptionTest extends \PHPUnit\Framework\TestCase
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

    public function testMissingImagick()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlankFilter(['id' => 'xxx'], new \Imagick);
        $instance->setImage(new \Imagick);
    }

    public function testMissingFilterId()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlankFilter([], new \Imagick);
    }

    public function testMissingColourLayerColour()
    {
        $this->expectException(PslayersException::class);

        $instance = new SolidLayer([
            'id' => 'solid',
            'width' => 10,
            'height' => 10,
        ], new \Imagick);
    }

    public function testMissingBlurFilterSigma()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlurFilter([
            'id' => 'hello',
            'radius' => 4,
        ], new \Imagick);
    }

    public function testMissingBlurFilterRadius()
    {
        $this->expectException(PslayersException::class);

        $instance = new BlurFilter([
            'id' => 'xxx',
            'sigme' => 5,
        ], new \Imagick);
    }

    public function testMissingPatternPattern()
    {
        $this->expectException(PslayersException::class);

        $instance = new PatternLayer([
            'id' => 'radial',
            'width' => 10,
            'height' => 10,
        ], new \Imagick);
    }

    public function testMissingPatternScale()
    {
        $this->expectException(PslayersException::class);

        $instance = new PatternLayer([
            'id' => 'radial',
            'width' => 10,
            'height' => 10,
            'pattern' => 'bricks',
        ], new \Imagick);
    }

    public function testMissingPatternScaleFilter()
    {
        $this->expectException(PslayersException::class);

        $instance = new PatternLayer([
            'id' => 'radial',
            'width' => 10,
            'height' => 10,
            'pattern' => 'bricks',
            'scale' => 2,
        ], new \Imagick);
    }

    public function testMissingRadialColour()
    {
        $this->expectException(PslayersException::class);

        $instance = new RadialGradientLayer([
            'id' => 'radial',
            'width' => 10,
            'height' => 10,
        ], new \Imagick);
    }

    public function testMissingGradientColour()
    {
        $this->expectException(PslayersException::class);

        $instance = new GradientLayer([
            'id' => 'gradient',
            'width' => 10,
            'height' => 10,
        ], new \Imagick);
    }

    public function testBadColour()
    {
        $this->expectException(PslayersException::class);

        ColourValidator::isValidColour('test');
    }
}
