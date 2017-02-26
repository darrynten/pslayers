<?php

namespace DarrynTen\Pslayers\Layers\Layer;

use DarrynTen\Pslayers\Layers\BaseLayer;

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
            !empty($config['textDecoration']) ? $config['textDecoration'] : \Imagick::DECORATION_NONE
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
            !empty($config['underColour']) ? $config['underColour'] : ''
        );

        $this->fillColour(
            !empty($config['fillColour']) ? $config['fillColour'] : ''
        );

        $this->strokeColour(
            !empty($config['strokeColour']) ? $config['strokeColour'] : ''
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
        ];
    }
}
