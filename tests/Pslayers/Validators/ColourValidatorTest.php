<?php

namespace DarrynTen\Pslayers\Tests\Validators;

use DarrynTen\Pslayers\Validators\ColourValidator;

class ColourValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertTrue(ColourValidator::isValidColour('#000000'));
        $this->assertTrue(ColourValidator::isValidColour('#FFF'));
        $this->assertTrue(ColourValidator::isValidColour('#b4d455'));
        $this->assertTrue(ColourValidator::isValidColour(null));
    }
}
