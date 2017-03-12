<?php

namespace DarrynTen\Pslayers\Tests\Pslayers;

use Imagick;

use DarrynTen\Pslayers\Pslayers;
use DarrynTen\Pslayers\Validators\ImageTypeValidator;
use DarrynTen\Pslayers\Layers\Layer\BlankLayer;
use DarrynTen\Pslayers\Layers\Layer\SolidLayer;
use DarrynTen\Pslayers\Layers\Layer\PatternLayer;
use DarrynTen\Pslayers\Layers\Layer\PlasmaLayer;
use DarrynTen\Pslayers\Layers\Layer\GradientLayer;
use DarrynTen\Pslayers\Layers\Layer\RadialGradientLayer;
use DarrynTen\Pslayers\Layers\Layer\TextLayer;
use DarrynTen\Pslayers\Layers\LayerCollection;
use DarrynTen\Pslayers\Filters\Filter\Fred\StainedGlass\StainedGlassFilter;
use DarrynTen\Pslayers\Filters\Filter\Fred\Dice\DiceFilter;

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
        $this->assertObjectHasAttribute('masterCanvas', $instance);

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
        $this->assertTrue(ImageTypeValidator::isValidImageType('jpg'));
        $this->assertFalse(ImageTypeValidator::isValidImageType('doc'));
    }

    public function testMasterRender()
    {
        $output = '/tmp/out.png';

        $width = 800;
        $height = 380;

        $config = [
            'id' => 11,
            'width' => $width,
            'height' => $height,
        ];

        $instance = new Pslayers($config);

        // background layer

        $backgroundLayer = new SolidLayer([
            'id' => 'master-layer-solid-base',
            'width' => $width,
            'height' => $height,
            'opacity' => 1.0,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'colour' => '#AF8',
        ]);

        $instance->addLayer($backgroundLayer, 0);

        // gradient layer

        $gradientLayer = new GradientLayer([
            'id' => 'master-layer-gradient',
            'width' => $width,
            'height' => $height,
            'opacity' => 1.0,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_DIFFERENCE,
            'startColour' => '#ED1021',
            'endColour' => '#FFF',
        ]);

        $instance->addLayer($gradientLayer, 1);

        // radial gradient layer

        $radialGradientLayer = new RadialGradientLayer([
            'id' => 'master-layer-radial-gradient',
            'width' => $width,
            'height' => $height,
            'opacity' => 1.0,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_BLEND,
            'startColour' => '#4A3',
            'endColour' => '#3FA',
        ]);

        $instance->addLayer($radialGradientLayer, 2);


        // pattern layer

        $patternLayer = new PatternLayer([
            'id' => 'master-layer-pattern-layer',
            'width' => $width,
            'height' => $height,
            'opacity' => 0.1,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_MULTIPLY,
            'pattern' => 'horizontal',
            'scale' => '1',
            'scaleFilter' => Imagick::FILTER_SINC,
        ]);

        $instance->addLayer($patternLayer, 3);


        // plasma layer
        $filter = new StainedGlassFilter([
            'id' => 'master-layer-stained-glass-filter',
            'kind' => 'random',
            'size' => 50,
            'offset' => 0,
            'ncolors' => 16,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => rand(),
        ]);

        // plasma layer
        $filter = new DiceFilter([
            'id' => 'master-layer-dice-filter',
            'size' => 100,
            'percent' => 100,
            'center' => '0,0',
            'radii' => '0,0',
            'rounding' => '0,0',
        ]);

        $plasmaLayer = new PlasmaLayer([
            'id' => 'master-layer-plasma-layer',
            'width' => $width,
            'height' => $height,
            'opacity' => 0.8,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_DARKEN,
            'filters' => [
                $filter
            ],
        ]);

        $instance->addLayer($plasmaLayer, 4);

        $instance->render();
    }
}
