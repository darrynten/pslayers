<?php

namespace DarrynTen\Pslayers\Tests\Pslayers;

use Imagick;

use DarrynTen\Pslayers\Pslayers;
use DarrynTen\Pslayers\Validators\ImageTypeValidator;
use DarrynTen\Pslayers\Layers\Layer\BlankLayer;
use DarrynTen\Pslayers\Layers\Layer\SolidLayer;
use DarrynTen\Pslayers\Layers\Layer\PatternLayer;
use DarrynTen\Pslayers\Layers\Layer\ImageLayer;
use DarrynTen\Pslayers\Layers\Layer\GroupLayer;
use DarrynTen\Pslayers\Layers\Layer\PlasmaLayer;
use DarrynTen\Pslayers\Layers\Layer\GradientLayer;
use DarrynTen\Pslayers\Layers\Layer\RadialGradientLayer;
use DarrynTen\Pslayers\Layers\Layer\TextLayer;
use DarrynTen\Pslayers\Layers\LayerCollection;
use DarrynTen\Pslayers\Filters\FilterCollection;
use DarrynTen\Pslayers\Filters\Filter\Fred\StainedGlass\StainedGlassFilter;
use DarrynTen\Pslayers\Filters\Filter\Fred\Dice\DiceFilter;
use DarrynTen\Pslayers\Filters\Filter\Standard\Blur\BlurFilter;

class PslayersTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $config = [
            'id' => 11,
            'width' => 800,
            'height' => 380,
        ];

        $instance = new Pslayers($config);
        $this->assertInstanceOf(Pslayers::class, $instance);

        $config = [
            'width' => 800,
            'height' => 380,
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

    public function testRender()
    {
        $config = [
            'id' => 11,
            'width' => 800,
            'height' => 380,
            'outputPath' => '/tmp/test.png',
        ];

        $instance = new Pslayers($config);
        $this->assertInstanceOf(Pslayers::class, $instance);

        $newLayer = new BlankLayer([
            'id' => 'aaa',
            'width' => 20,
            'height' => 20
        ]);

        $instance->addLayer($newLayer, 1);
        $instance->render();
        $this->assertFileExists('/tmp/test.png');
    }

    public function testValidation()
    {
        $this->assertTrue(ImageTypeValidator::isValidImageType('jpg'));
        $this->assertFalse(ImageTypeValidator::isValidImageType('doc'));
    }

    public function testMasterRender()
    {
        $output = '/tmp/tmp.png';

        $width = 830;
        $height = 360;

        $config = [
            'id' => 11,
            'width' => $width,
            'height' => $height,
            'outputPath' => $output,
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
            'colour' => '#0F0',
        ]);

        $instance->addLayer($backgroundLayer, 0);

        // gradient layer
        $gradientLayer = new GradientLayer([
            'id' => 'master-layer-gradient',
            'width' => $width,
            'height' => $height / 2,
            'opacity' => 0.9,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_OVER,
            'startColour' => '#F00',
            'endColour' => 'transparent',
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
        $this->assertEquals('#3FA', $radialGradientLayer->endColour());
        $this->assertEquals('#4A3', $radialGradientLayer->startColour());

        // pattern layer
        $patternLayer = new PatternLayer([
            'id' => 'master-layer-pattern-layer',
            'width' => $width,
            'height' => $height,
            'opacity' => 0.1,
            'positionX' => 100,
            'positionY' => 200,
            'composite' => Imagick::COMPOSITE_MULTIPLY,
            'pattern' => 'horizontal',
            'scale' => '1',
            'scaleFilter' => Imagick::FILTER_SINC,
        ]);

        $instance->addLayer($patternLayer, 3);
        $this->assertEquals(1, $patternLayer->scale());
        $this->assertEquals('horizontal', $patternLayer->pattern());

        // plasma layer
        $stainedGlassFilter = new StainedGlassFilter([
            'id' => 'master-layer-stained-glass-filter',
            'kind' => 'random',
            'size' => 75,
            'offset' => 0,
            'ncolors' => 16,
            'bright' => 100,
            'ecolor' => 'black',
            'thick' => 0,
            'rseed' => rand(),
        ]);

        $diceFilter = new DiceFilter([
            'id' => 'master-layer-dice-filter',
            'size' => 75,
            'percent' => 100,
            'center' => '0,0',
            'radii' => '0,0',
            'rounding' => '0,0',
        ]);

        $blurFilter = new BlurFilter([
            'id' => 'master-layer-blur-filter',
            'radius' => 5,
            'sigma' => 3,
        ]);

        $plasmaLayer = new PlasmaLayer([
            'id' => 'master-layer-plasma-layer',
            'width' => $width,
            'height' => $height,
            'opacity' => 0.8,
            'positionX' => 100,
            'positionY' => 100,
            'composite' => Imagick::COMPOSITE_DARKEN,
            'filters' => [
                $blurFilter,
                // $diceFilter,
                $stainedGlassFilter,
            ],
        ]);

        $instance->addLayer($plasmaLayer, 4);

        $textLayerConfig = [
            'id' => 'master-text-layer-1',
            'width' => $width,
            'height' => $height,
            'positionX' => 16,
            'positionY' => 0,
            'text' => 'Some Text',
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'fontColour' => '#FFF',
            'font' => __DIR__ . '/fonts/Passion_One/PassionOne-Regular.ttf',
            'strokeColour' => 'none',
            'strokeOpacity' => 0.0,
            'fontSize' => 56,
        ];

        $textLayer = new TextLayer($textLayerConfig);

        $textLayer2Config = [
            'id' => 'master-text-layer-2',
            'width' => $width,
            'height' => $height,
            'positionX' => 16,
            'positionY' => 65,
            'text' => 'More Text',
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'fontColour' => '#FFF',
            'font' => __DIR__ . '/fonts/Passion_One/PassionOne-Regular.ttf',
            'strokeColour' => '#FFF',
            'strokeOpacity' => 0.0,
            'fontSize' => 26,
        ];

        $textLayer2 = new TextLayer($textLayer2Config);

        $groupLayerConfig = [
            'id' => 'master-group-text-layer',
            'width' => $width,
            'height' => $height,
            'positionX' => 150,
            'positionY' => 100
        ];

        $groupLayer = new GroupLayer($groupLayerConfig);

        $groupLayer->addLayer($textLayer, 0);
        $groupLayer->addLayer($textLayer2, 1);

        $instance->addLayer($groupLayer, 6);

        $imageLayer = new ImageLayer([
            'id' => 'master-image-layer',
            'width' => $width,
            'height' => $height,
            'imageUrl' => __DIR__ . '/image/test.png',
            'composite' => Imagick::COMPOSITE_MULTIPLY,
            'filters' => [
                $stainedGlassFilter,
            ],
        ]);

        $instance->addLayer($imageLayer, 7);

        $instance->render();
        $this->assertFileExists(__DIR__ . '/image/test.png');
        $this->assertFileExists('/tmp/tmp.png');
    }

    // Output path was not really optional
    public function testOptionalOutputPath()
    {
        $width = 830;
        $height = 360;

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
            'colour' => '#0F0',
        ]);

        $instance->addLayer($backgroundLayer, 0);

        // gradient layer
        $gradientLayer = new GradientLayer([
            'id' => 'master-layer-gradient',
            'width' => $width,
            'height' => $height / 2,
            'opacity' => 0.9,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_OVER,
            'startColour' => '#F00',
            'endColour' => 'transparent',
        ]);

        $instance->addLayer($backgroundLayer, 0);
        $instance->addLayer($gradientLayer, 1);
        $img = $instance->render();

        $this->assertInstanceOf(Pslayers::class, $instance);
        $this->assertNotEmpty($instance->layers);
        $this->assertInstanceOf(LayerCollection::class, $instance->layers);
        $this->assertInstanceOf(Imagick::class, $img);
        $this->assertEquals($width, $img->getImageWidth());
        $this->assertEquals($height, $img->getImageHeight());
        $this->assertEquals('png32', $img->getImageFormat());
    }
}
