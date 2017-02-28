<?php

namespace DarrynTen\Pslayers\Layers\Layer;

use DarrynTen\Pslayers\Layers\BaseLayer;
use DarrynTen\Pslayers\Validators\ColourValidator;

/**
 * Pslayers Text Layer
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class TextLayer extends BaseLayer
{
    /**
     * Text Content
     *
     * @var string $text
     */
    public $text;

    /**
     * Text Content Aignment
     *
     * @var string $textAlignment
     */
    public $textAlignment;

    /**
     * Text Content Decoration
     *
     * @var string $textAlignment
     */
    public $textDecoration;

    /**
     * Font name
     *
     * @var string $font The name of the font
     */
    public $font;

    /**
     * Font family
     *
     * @var string $fontFamily The name of the font family
     */
    public $fontFamily;

    /**
     * Font size
     *
     * @var string $fontSize The size of the font
     */
    public $fontSize;

    /**
     * Font weight
     *
     * @var int $fontWeight The weight of the font
     */
    public $fontWeight;

    /**
     * Font stretchh
     *
     * @var int $fontStretch
     */
    public $fontStretch;

    /**
     * Font Style
     *
     * @var int $fontStyle
     */
    public $fontStyle;

    /**
     * Font under colour
     *
     * @var string $underColour The colour under the font
     */
    public $underColour;

    /**
     * Font fill colour
     *
     * @var string $fillColour The fill colour of the font
     */
    public $fillColour;

    /**
     * Fill opacity
     *
     * @var float $fillOpacity
     */
    public $fillOpacity;

    /**
     * Font stroke colour
     *
     * @var string $strokeColour The outline colour of the font
     */
    public $strokeColour;

    /**
     * Stroke width
     *
     * @var int $strokeWidth The width of the stroke
     */
    public $strokeWidth;

    /**
     * Stroke opacity
     *
     * @var float $strokeOpacity The opacity of the stroke
     */
    public $strokeOpacity;

    /**
     * Imagick Draw object
     *
     * @var ImagicDraw $drawObject
     */
    private $drawObject;

    /**
     * Construct the text layer
     */
    public function __construct(array $config)
    {
        $this->text(
            !empty($config['text']) ? $config['text'] : ''
        );

        $this->textAlignment(
            !empty($config['textAlignment']) ? $config['textAlignment'] : \Imagick::ALIGN_LEFT
        );

        $this->textDecoration(
            !empty($config['textDecoration']) ? $config['textDecoration'] : \Imagick::DECORATION_NO
        );

        $this->font(
            !empty($config['font']) ? $config['font'] : 'serif'
        );

        $this->fontFamily(
            !empty($config['fontFamily']) ? $config['fontFamily'] : 'Times'
        );

        $this->fontSize(
            !empty($config['fontSize']) ? $config['fontSize'] : 16
        );

        $this->fontWeight(
            !empty($config['fontWeight']) ? $config['fontWeight'] : 200
        );

        $this->fontStretch(
            !empty($config['fontStretch']) ? $config['fontStretch'] : \Imagick::STRETCH_ANY
        );

        $this->fontStyle(
            !empty($config['fontStyle']) ? $config['fontStyle'] : \Imagick::STYLE_NORMAL
        );

        $this->underColour(
            !empty($config['underColour']) ? $config['underColour'] : null
        );

        $this->fillColour(
            !empty($config['fillColour']) ? $config['fillColour'] : null
        );

        $this->fillOpacity(
            !empty($config['fillOpacity']) ? $config['fillOpacity'] : 1.0
        );

        $this->strokeColour(
            !empty($config['strokeColour']) ? $config['strokeColour'] : null
        );

        $this->strokeWidth(
            !empty($config['strokeWidth']) ? $config['strokeWidth'] : 1
        );

        $this->strokeOpacity(
            !empty($config['strokeOpacity']) ? $config['strokeOpacity'] : 1
        );

        parent::__construct($config);
    }

    /**
     * Get and set the font
     *
     * @param null|int $font The font
     *
     * @return boolean|string
     */
    public function font(string $font = null)
    {
        if ($font === null) {
            return $this->font;
        }

        return $this->font = $font;
    }

    /**
     * Get and set the size
     *
     * @param null|int $size The size
     *
     * @return boolean|int
     */
    public function fontSize(int $size = null)
    {
        if ($size === null) {
            return $this->fontSize;
        }

        return $this->fontSize = $size;
    }

    /**
     * Get and set the fontFamily
     *
     * @param null|int $fontFamily The fontFamily
     *
     * @return boolean|string
     */
    public function fontFamily(string $fontFamily = null)
    {
        if ($fontFamily === null) {
            return $this->fontFamily;
        }

        return $this->fontFamily = $fontFamily;
    }

    /**
     * Get and set the fontWeight
     *
     * @param null|int $fontWeight The fontWeight
     *
     * @return boolean|string
     */
    public function fontWeight(int $fontWeight = null)
    {
        if ($fontWeight === null) {
            return $this->fontWeight;
        }

        return $this->fontWeight = $fontWeight;
    }

    /**
     * Get and set the fontStretch
     *
     * @param null|int $fontStretch The fontStretch
     *
     * @return boolean|int
     */
    public function fontStretch(int $fontStretch = null)
    {
        if ($fontStretch === null) {
            return $this->fontStretch;
        }

        return $this->fontStretch = $fontStretch;
    }

    /**
     * Get and set the fontStyle
     *
     * @param null|int $fontStyle The fontStyle
     *
     * @return boolean|int
     */
    public function fontStyle(int $fontStyle = null)
    {
        if ($fontStyle === null) {
            return $this->fontStyle;
        }

        return $this->fontStyle = $fontStyle;
    }

    /**
     * Get and set the underColour
     *
     * @param null|int $underColour The underColour
     *
     * @return boolean|string
     */
    public function underColour(string $underColour = null)
    {
        ColourValidator::isValidColour($underColour);

        if ($underColour === null) {
            return $this->underColour;
        }

        return $this->underColour = $underColour;
    }

    /**
     * Get and set the fillColour
     *
     * @param null|int $fillColour The fillColour
     *
     * @return boolean|string
     */
    public function fillColour(string $fillColour = null)
    {
        ColourValidator::isValidColour($fillColour);

        if ($fillColour === null) {
            return $this->fillColour;
        }

        return $this->fillColour = $fillColour;
    }

    /**
     * Get and set the fillOpacity
     *
     * @param null|int $fillOpacity The fillOpacity
     *
     * @return boolean|float
     */
    public function fillOpacity(float $fillOpacity = null)
    {
        if ($fillOpacity === null) {
            return $this->fillOpacity;
        }

        return $this->fillOpacity = $fillOpacity;
    }

    /**
     * Get and set the strokeColour
     *
     * @param null|int $strokeColour The strokeColour
     *
     * @return boolean|string
     */
    public function strokeColour(string $strokeColour = null)
    {
        ColourValidator::isValidColour($strokeColour);

        if ($strokeColour === null) {
            return $this->strokeColour;
        }

        return $this->strokeColour = $strokeColour;
    }

    /**
     * Get and set the strokeWidth
     *
     * @param null|int $strokeWidth The strokeWidth
     *
     * @return boolean|int
     */
    public function strokeWidth(int $strokeWidth = null)
    {
        if ($strokeWidth === null) {
            return $this->strokeWidth;
        }

        return $this->strokeWidth = $strokeWidth;
    }

    /**
     * Get and set the strokeOpacity
     *
     * @param null|int $strokeOpacity The strokeOpacity
     *
     * @return boolean|float
     */
    public function strokeOpacity(float $strokeOpacity = null)
    {
        if ($strokeOpacity === null) {
            return $this->strokeOpacity;
        }

        return $this->strokeOpacity = $strokeOpacity;
    }

    /**
     * Get and set the textAlignment
     *
     * @param null|int $textAlignment The textAlignment
     *
     * @return boolean|int
     */
    public function textAlignment(int $textAlignment = null)
    {
        if ($textAlignment === null) {
            return $this->textAlignment;
        }

        return $this->textAlignment = $textAlignment;
    }

    /**
     * Get and set the textDecoration
     *
     * @param null|int $textDecoration The textDecoration
     *
     * @return boolean|int
     */
    public function textDecoration(int $textDecoration = null)
    {
        if ($textDecoration === null) {
            return $this->textDecoration;
        }

        return $this->textDecoration = $textDecoration;
    }

    /**
     * Get and set the text
     *
     * @param null|string $text The text
     *
     * @return boolean|string
     */
    public function text(string $text = null)
    {
        if ($text === null) {
            return $this->text;
        }

        return $this->text = $text;
    }

    /**
     * Returns an representation of the layer
     *
     * @return array
     */
    public function getLayerDetailsArray(): array
    {
        return [
            'id' => $this->id,
            'opacity' => $this->opacity(),
            'width' => $this->width(),
            'height' => $this->height(),
            'positionX' => $this->positionX(),
            'positionY' => $this->positionY(),
            'composite' => $this->composite(),
            'text' => $this->text(),
            'textAlignment' => $this->textAlignment(),
            'textDecoration' => $this->textDecoration(),
            'font' => $this->font(),
            'fontFamily' => $this->fontFamily(),
            'fontSize' => $this->fontSize(),
            'fontWeight' => $this->fontWeight(),
            'fontStretch' => $this->fontStretch(),
            'fontStyle' => $this->fontStyle(),
            'underColour' => $this->underColour(),
            'fillColour' => $this->fillColour(),
            'fillOpacity' => $this->fillOpacity(),
            'strokeColour' => $this->strokeColour(),
            'strokeWidth' => $this->strokeWidth(),
            'strokeOpacity' => $this->strokeOpacity(),
        ];
    }
}
