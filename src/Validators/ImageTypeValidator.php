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

class ImageTypeValidator
{
    /**
     * The valid image types
     *
     * @var array $validImageTypes
     */
    private static $validImageTypes = [
        'png',
        'jpg',
        'gif',
    ];

    /**
     * Check if valid image type
     *
     * @return boolean
     */
    public static function isValidImageType(string $type)
    {
        return in_array($type, self::$validImageTypes);
    }
}
