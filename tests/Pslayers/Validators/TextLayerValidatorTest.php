<?php

namespace DarrynTen\Pslayers\Tests\Validators;

use DarrynTen\Pslayers\Validators\TextLayerValidator;
use DarrynTen\Pslayers\Exceptions\PslayersException;

class TextLayerValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testValidation()
    {
        $this->assertTrue(TextLayerValidator::isValidTextAlignment(\Imagick::ALIGN_UNDEFINED));
        $this->assertTrue(TextLayerValidator::isValidTextDecoration(\Imagick::DECORATION_UNDERLINE));
        $this->assertTrue(TextLayerValidator::isValidFontStyle(\Imagick::STYLE_ITALIC));
        $this->assertTrue(TextLayerValidator::isValidFontStretch(\Imagick::STRETCH_CONDENSED));
    }

    public function testFontStyleTypeError()
    {
        $this->expectException(\TypeError::class);
        TextLayerValidator::isValidFontStyle('text');
    }

    public function testFontStyleException()
    {
        $this->expectException(PslayersException::class);
        TextLayerValidator::isValidFontStyle(-1000);
    }

    public function testFontStretchException()
    {
        $this->expectException(PslayersException::class);
        TextLayerValidator::isValidFontStretch(-0.1);
    }

    public function testTextAlignmentException()
    {
        $this->expectException(PslayersException::class);
        TextLayerValidator::isValidTextAlignment(1000000000);
    }

    public function testTextDecorationException()
    {
        $this->expectException(PslayersException::class);
        TextLayerValidator::isValidTextDecoration(1000000000);
    }
}
