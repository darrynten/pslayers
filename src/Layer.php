<?php

namespace DarrynTen\Pslayers;

use PslayersException;

/**
 * Pslayers Layer Item
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class Layer
{
    /**
     * ID
     *
     * Unique identifier for this layer
     *
     * @var string $id
     */
    private $id;

    /**
     * Opacity
     *
     * @var float $opacity
     */
    private $opacity;

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

        $this->id = $config['id'];
        $this->opacity = !empty($config['opacity']) ? $config['opacity'] : 1;
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

        // Otherwise Set
        if ($opacity <= 0.0) {
            return $this->opacity = 0.0;
        }

        if ($opacity >= 1.0) {
            return $this->opacity = 1.0;
        }

        return $this->opacity = $opacity;
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
        ];
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
}
