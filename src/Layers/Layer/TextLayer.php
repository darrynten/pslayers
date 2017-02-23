<?php

namespace DarrynTen\Pslayers\Layers\Layer;

use Imagick;

use DarrynTen\Pslayers\Layers\BaseLayer;
use DarrynTen\Pslayers\PslayersException;

/**
 * Pslayers Layer Item
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

    public function __construct(array $config)
    {
        $this->text(
            !empty($config['text']) ? $config['text'] : ''
        );

        parent::__construct($config);
    }

    /**
     * Get and set the width of the layer
     *
     * @param null|int $width The width
     *
     * @return boolean|int
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
    public function getLayerDetailsArray()
    {
        return [
            'id' => $this->id,
            'opacity' => $this->opacity(),
            'width' => $this->width(),
            'height' => $this->height(),
            'positionX' => $this->positionX(),
            'positionY' => $this->positionY(),
            'text' => $this->text(),
        ];
    }
}
