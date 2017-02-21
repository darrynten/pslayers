<?php
/**
 * Pslayers Validation
 *
 * @category Validation
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */

namespace DarrynTen\Pslayers;

class Validation
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
