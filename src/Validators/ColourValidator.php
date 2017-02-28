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
     * @var array $validShortHex
     */
    private static $validShortHex = '/^\#[0-9A-Fa-f]{3}$/';

    /**
     * Valid long hex (#FFFFFF)
     *
     * @var array $validLongHex
     */
    private static $validLongHex = '/^\#[0-9A-Fa-f]{6}$/';

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
        if ($opacity < 0) {
            throw new PslayersException('Invalid Opacity, must be between 0 and 1');
        }

        if ($opacity > 1.0) {
            throw new PslayersException('Invalid Opacity, must be between 0 and 1');
        }

        return true;
    }
}
