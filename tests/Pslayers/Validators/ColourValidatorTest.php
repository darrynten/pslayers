<?php

namespace DarrynTen\Pslayers\Tests\Validators;

use DarrynTen\Pslayers\Validators\ColourValidator;
use DarrynTen\Pslayers\Exceptions\PslayersException;

class ColourValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testValidation()
    {
        $this->assertTrue(ColourValidator::isValidColour('#000000'));
        $this->assertTrue(ColourValidator::isValidColour('#FFF'));
        $this->assertTrue(ColourValidator::isValidColour('#b4d455'));
        $this->assertTrue(ColourValidator::isValidColour('rgb(255,128,1)'));
        $this->assertTrue(ColourValidator::isValidColour('rgba(255,128,0, 1)'));
        $this->assertTrue(ColourValidator::isValidColour(null));

        $this->assertTrue(ColourValidator::isValidOpacity(1));
        $this->assertTrue(ColourValidator::isValidOpacity(0));
        $this->assertTrue(ColourValidator::isValidOpacity(0.1));
        $this->assertTrue(ColourValidator::isValidOpacity(1.0));
        $this->assertTrue(ColourValidator::isValidOpacity(0.0));
    }

    public function testValidationExceptions()
    {
        $this->expectException(\TypeError::class);
        ColourValidator::isValidOpacity('text');
    }

    public function testOpacityExceptionLow()
    {
        $this->expectException(PslayersException::class);
        ColourValidator::isValidOpacity(-0.1);
    }

    public function testOpacityExceptionHigh()
    {
        $this->expectException(PslayersException::class);
        ColourValidator::isValidOpacity(1.1);
    }
}
