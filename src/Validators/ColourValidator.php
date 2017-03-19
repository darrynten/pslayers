<?php
/**
 * Pslayers Validation
 *
 * @category Validators
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */

namespace DarrynTen\Pslayers\Validators;

use DarrynTen\Pslayers\Exceptions\PslayersException;

class ColourValidator
{
    /**
     * Valid short hex (#FFF)
     *
     * @var string $validShortHex
     */
    private static $validShortHex = '/^\#[0-9A-Fa-f]{3}$/';

    /**
     * Valid long hex (#FFFFFF)
     *
     * @var string $validLongHex
     */
    private static $validLongHex = '/^\#[0-9A-Fa-f]{6}$/';

    /**
     * Valid rgba
     *
     * rgba(1,1,1,1)
     * rgba(0,10,0,0)
     * rgba(0, 0 ,0, 0.0)
     * rgba( 255,255,255,1)
     * rgba(255, 111 ,0 , 0.5 )
     *
     * @var string $validRgba
     */
    private static $validRgba = '/^rgba\(\s?[0-2]{0,1}?[0-9]{0,2}?\s?,\s?[0-2]{0,1}?[0-9]{0,2}?\s?,\s?[0-2]{0,1}[0-9]{0,2}?\s?(,\s?[0-1]{1}\.*?[0-9]?\s?)?\)$/';

    /**
     * Valid rgb
     *
     * @var string $validRgb
     */
    private static $validRgb = '/^rgb\(\s?[0-2]{0,1}?[0-9]{0,2}?\s?,\s?[0-2]{0,1}?[0-9]{0,2}?\s?,\s?[0-2]{0,1}[0-9]{0,2}?\s?\)$/';

    /**
     * Valid word
     *
     * @var array $validLongHex
     */
    private static $validWord = '/^none$/';

    /**
     * Check if valid colour
     *
     * @return boolean
     */
    public static function isValidColour(string $colour = null)
    {
        // A null colour is just transparent
        if (is_null($colour)) {
            return true;
        }

        if (preg_match(self::$validShortHex, $colour)) {
            return true;
        }

        if (preg_match(self::$validLongHex, $colour)) {
            return true;
        }

        if (preg_match(self::$validRgb, $colour)) {
            return true;
        }

        if (preg_match(self::$validRgba, $colour)) {
            return true;
        }

        if (preg_match(self::$validWord, $colour)) {
            return true;
        }

        throw new PslayersException('Invalid Colour');
    }

    /**
     * Check if a valid opacity
     *
     * Float between 0.0 and 1.0
     *
     * @return boolean
     */
    public static function isValidOpacity(float $opacity)
    {
        if ($opacity < 0 || $opacity > 1) {
            throw new PslayersException('Invalid Opacity, must be between 0 and 1');
        }

        return true;
    }
}
