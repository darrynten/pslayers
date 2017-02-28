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

class TextLayerValidator
{
    /**
     * Valid Text Alignments
     *
     * @var array $validAlignments
     */
    private static $validTextAlignments = [
        \Imagick::ALIGN_UNDEFINED,
        \Imagick::ALIGN_LEFT,
        \Imagick::ALIGN_CENTER,
        \Imagick::ALIGN_RIGHT,
    ];

    /**
     * Valid Text Decorations
     *
     * @var array $validDecorations
     */
    private static $validTextDecorations = [
        \Imagick::DECORATION_NO,
        \Imagick::DECORATION_UNDERLINE,
        \Imagick::DECORATION_OVERLINE,
        \Imagick::DECORATION_LINETHROUGH,
    ];

    /**
     * Valid Font Stretches
     *
     * @var array $validFontStretches
     */
    private static $validFontStretches = [
        \Imagick::STRETCH_NORMAL,
        \Imagick::STRETCH_ULTRACONDENSED,
        \Imagick::STRETCH_CONDENSED,
        \Imagick::STRETCH_SEMICONDENSED,
        \Imagick::STRETCH_SEMIEXPANDED,
        \Imagick::STRETCH_EXPANDED,
        \Imagick::STRETCH_EXTRAEXPANDED,
        \Imagick::STRETCH_ULTRAEXPANDED,
        \Imagick::STRETCH_ANY,
    ];

    /**
     * Valid Font Styles
     *
     * @var array $validFontStyles
     */
    private static $validFontStyles = [
        \Imagick::STYLE_NORMAL,
        \Imagick::STYLE_ITALIC,
        \Imagick::STYLE_OBLIQUE,
        \Imagick::STYLE_ANY,
    ];

    /**
     * Check if valid text alignment
     *
     * @return boolean
     */
    public static function isValidTextAlignment(int $alignment)
    {
        if (!in_array($alignment, self::$validTextAlignments)) {
            throw new PslayersException('Invalid Text Alignment');
        }

        return true;
    }

    /**
     * Check if valid text decoration
     *
     * @return boolean
     */
    public static function isValidTextDecoration(int $decoration)
    {
        if (!in_array($decoration, self::$validTextDecorations)) {
            throw new PslayersException('Invalid Text Decoration');
        }

        return true;
    }


    /**
     * Check if valid font stretch
     *
     * @return boolean
     */
    public static function isValidFontStretch(int $stretch)
    {
        if (!in_array($stretch, self::$validFontStretches)) {
            throw new PslayersException('Invalid Font Stretch');
        }

        return true;
    }


    /**
     * Check if valid font style
     *
     * @return boolean
     */
    public static function isValidFontStyle(int $style)
    {
        if (!in_array($style, self::$validFontStyles)) {
            throw new PslayersException('Invalid Font Style');
        }

        return true;
    }
}
