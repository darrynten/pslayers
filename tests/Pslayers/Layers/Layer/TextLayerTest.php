<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use DarrynTen\Pslayers\Layers\Layer\TextLayer;

class TextLayerTest extends \PHPUnit_Framework_TestCase
{
    public function testNewTextLayer()
    {
        $layer = new TextLayer([
            'id' => 1,
            'width' => 500,
            'height' => 500,
        ]);

        $this->assertInstanceOf(TextLayer::class, $layer);
        $this->assertObjectHasAttribute('font', $layer);
        $this->assertObjectHasAttribute('fontSize', $layer);
        $this->assertObjectHasAttribute('fillColour', $layer);
    }

    public function testDefaultText()
    {
        $layer = new TextLayer([
            'id' => 1,
            'width' => 200,
            'height' => 2000
        ]);

        $this->assertEquals('', $layer->text());

        $layer->text('text');
        $this->assertEquals('text', $layer->text());
    }

    public function testText()
    {
        $layer = new TextLayer([
            'id' => 1,
            'width' => 200,
            'height' => 2000
        ]);

        $this->assertEquals('Times', $layer->font());
        $this->assertEquals(16, $layer->fontSize());

        $layer->fontFamily('Ubuntu');
        $this->assertEquals('Ubuntu', $layer->fontFamily());

        $layer->font('Ubuntu');
        $this->assertEquals('Ubuntu', $layer->font());

        $layer->fontSize(14);
        $this->assertEquals(14, $layer->fontSize());

        $layer->fontWeight(300);
        $this->assertEquals(300, $layer->fontWeight());

        $layer->fontStretch(\Imagick::STRETCH_EXPANDED);
        $this->assertEquals(\Imagick::STRETCH_EXPANDED, $layer->fontStretch());

        $layer->fontStyle(\Imagick::STYLE_ITALIC);
        $this->assertEquals(\Imagick::STYLE_ITALIC, $layer->fontStyle());

        $this->assertEquals('none', $layer->underColour());
        $layer->underColour('#FFF');
        $this->assertEquals('#FFF', $layer->underColour());

        $this->assertEquals('#FFF', $layer->fillColour());
        $layer->fillColour('#B4D455');
        $this->assertEquals('#B4D455', $layer->fillColour());

        $this->assertEquals('none', $layer->strokeColour());
        $layer->strokeColour('#AAA');
        $this->assertEquals('#AAA', $layer->strokeColour());


        $layer->fillOpacity(0.5);
        $this->assertEquals(0.5, $layer->fillOpacity());

        $layer->strokeWidth(2);
        $this->assertEquals(2, $layer->strokeWidth());

        $layer->strokeOpacity(1.0);
        $this->assertEquals(1.0, $layer->strokeOpacity());
    }

    public function testGetTextLayerArray()
    {
        $expected = [
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'positionX' => 1,
            'positionY' => 1,
            'opacity' => 1.0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'text' => '',
            'textAlignment' => \Imagick::ALIGN_LEFT,
            'textDecoration' => \Imagick::DECORATION_NO,
            'font' => 'Times',
            'fontFamily' => 'Ubuntu',
            'fontSize' => 16,
            'fontWeight' => 200,
            'fontStretch' => \Imagick::STRETCH_ANY,
            'fontStyle' => \Imagick::STYLE_NORMAL,
            'underColour' => 'none',
            'fillColour' => '#FFF',
            'fillOpacity' => 1.0,
            'strokeColour' => 'none',
            'strokeWidth' => 1,
            'strokeOpacity' => 0.0,
        ];

        $layer = new TextLayer([
            'id' => 1,
            'width' => 400,
            'height' => 200,
            'fontFamily' => 'Ubuntu',
            'opacity' => 1.0,
            'positionX' => 1,
            'positionY' => 1,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsArray());
    }

    public function testGetLayerJson()
    {
        $expected = json_encode([
            'id' => 1,
            'opacity' => 1,
            'width' => 0,
            'height' => 0,
            'positionX' => 0,
            'positionY' => 0,
            'composite' => Imagick::COMPOSITE_DEFAULT,
            'text' => '',
            'textAlignment' => \Imagick::ALIGN_LEFT,
            'textDecoration' => \Imagick::DECORATION_NO,
            'font' => 'Times',
            'fontFamily' => null,
            'fontSize' => 16,
            'fontWeight' => 200,
            'fontStretch' => \Imagick::STRETCH_ANY,
            'fontStyle' => \Imagick::STYLE_NORMAL,
            'underColour' => 'none',
            'fillColour' => '#FFF',
            'fillOpacity' => 1.0,
            'strokeColour' => 'none',
            'strokeWidth' => 1,
            'strokeOpacity' => 0.0,
        ]);

        $layer = new TextLayer([
            'id' => 1,
            'width' => -100,
            'height' => -100,
        ]);

        $this->assertEquals($expected, $layer->getLayerDetailsJson());
    }
}
