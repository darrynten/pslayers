<?php

namespace DarrynTen\Pslayers\Layers;

use Imagick;
use ImagickPixel;
use DarrynTen\Pslayers\Exceptions\PslayersException;
use DarrynTen\Pslayers\Filters\FilterCollection;
use DarrynTen\Pslayers\Validators\ColourValidator;

/**
 * Pslayers Layer Item
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
abstract class BaseLayer implements LayerInterface
{
    /**
     * ID
     *
     * Unique identifier for this layer
     *
     * @var string $id
     */
    public $id;

    /**
     * The width of this layer
     *
     * @var int $width
     */
    public $width;

    /**
     * The height of this layer
     *
     * @var int $height
     */
    public $height;

    /**
     * The x position of this layer
     *
     * @var int $positionX
     */
    public $positionX;

    /**
     * The y position of this layer
     *
     * @var int $positionY
     */
    public $positionY;

    /**
     * Opacity
     *
     * @var float $opacity
     */
    public $opacity;

    /**
     * Layer Composite
     *
     * Imagick::COMPOSITE_DEFAULT is an example
     *
     * @var $composite
     */
    public $composite = Imagick::COMPOSITE_OVER;

    /**
     * Layer Filters
     *
     * @var array $filters
     */
    public $filters;

    /**
     * @var Imagick $canvas
     */
    public $canvas;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (!isset($config['id'])) {
            throw new PslayersException('No ID Set for Layer');
        }

        if (!isset($config['width'])) {
            throw new PslayersException('No Width Set for Layer');
        }

        if (!isset($config['height'])) {
            throw new PslayersException('No Height Set for Layer');
        }

        $this->id = $config['id'];
        $this->height($config['height']);
        $this->width($config['width']);

        // Optionals
        $this->positionX(
            !empty($config['positionX']) ? $config['positionX'] : 0
        );

        $this->positionY(
            !empty($config['positionY']) ? $config['positionY'] : 0
        );

        $this->opacity(
            !empty($config['opacity']) ? $config['opacity'] : 1
        );

        $this->composite(
            !empty($config['composite']) ? $config['composite'] : Imagick::COMPOSITE_DEFAULT
        );

        if (!isset($config['filters'])) {
            $config['filters'] = [];
        }
        $this->filters = new FilterCollection($config['filters']);

        $this->canvas = new Imagick();
        $this->canvas->newImage($this->width, $this->height, new ImagickPixel('none'));
        $this->canvas->setImageFormat('png32');
    }

    /**
     * Get and set the width of the layer
     *
     * @param null|int $width The width
     *
     * @return boolean|int
     */
    public function width(int $width = null)
    {
        if ($width === null) {
            return $this->width;
        }

        // No negatives
        if ($width <= 0) {
            return $this->width = 0;
        }

        return $this->width = $width;
    }

    /**
     * Get and set the height of the layer
     *
     * @param null|int $height The height
     *
     * @return boolean|int
     */
    public function height(int $height = null)
    {
        if ($height === null) {
            return $this->height;
        }

        if ($height <= 0) {
            return $this->height = 0;
        }

        return $this->height = $height;
    }

    /**
     * Get and set the X pos
     *
     * @param null|int $position The X position
     *
     * @return boolean|int
     */
    public function positionX(int $position = null)
    {
        if ($position === null) {
            return $this->positionX;
        }

        return $this->positionX = $position;
    }

    /**
     * Get and set the Y pos
     *
     * @param null|int $position The Y position
     *
     * @return boolean|int
     */
    public function composite(int $imagickConstant = null)
    {
        if ($imagickConstant === null) {
            return $this->composite;
        }

        return $this->composite = $imagickConstant;
    }

    /**
     * Get and set the Y pos
     *
     * @param null|int $position The Y position
     *
     * @return boolean|int
     */
    public function positionY(int $position = null)
    {
        if ($position === null) {
            return $this->positionY;
        }

        return $this->positionY = $position;
    }

    /**
     * Sets and gets the opacity of the layer
     *
     * @param null|float $opacity Float value between 0 and 1
     *
     * @return boolean|float
     */
    public function opacity(float $opacity = null)
    {
        // Get
        if ($opacity === null) {
            return $this->opacity;
        }

        ColourValidator::isValidOpacity($opacity);

        return $this->opacity = $opacity;
    }

    /**
     * Returns a JSON representation of the layer
     *
     * @return string
     */
    public function getLayerDetailsJson()
    {
        return json_encode($this->getLayerDetailsArray());
    }

    public function render()
    {
        if (sizeof($this->filters->collection > 0)) {
            foreach ($this->filters->collection as $filter) {
                $filter->setImage($this->canvas);
                $filter->render();
                $this->canvas = $filter->getImage();
            }
        }

        return $this->canvas;
    }
}
