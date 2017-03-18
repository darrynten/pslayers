<?php

namespace DarrynTen\Pslayers\Layers\Layer;

use DarrynTen\Pslayers\Layers\BaseLayer;
use DarrynTen\Pslayers\Exceptions\PslayersException;

/**
 * Pslayers Blank Layer
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class ImageLayer extends BaseLayer
{
    /**
     * Image
     *
     * @var string $colour
     */
    public $image;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!empty($config['imageUrl'])) {
            // TODO validate
            $image = file_get_contents($config['imageUrl']);

            $temp = new \Imagick;
            $temp->setSize($config['width'], $config['height']);
            $temp->readImageBlob($image);
            $temp->setImageFormat('png');

            $this->canvas = $temp;
        } else {
            $this->image(
                !empty($config['image']) ? $config['image'] : null
            );
        }
    }

    /**
     * Get and set the image
     *
     * @param null|int $image The image
     *
     * @return boolean|string
     */
    public function image(string $image = null)
    {
        if ($image === null) {
            return $this->image;
        }

        return $this->image = $image;
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
            'composite' => $this->composite(),
            'image' => $this->image(),
        ];
    }
}
