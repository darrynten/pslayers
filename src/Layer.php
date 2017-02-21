<?php

namespace DarrynTen\Pslayers;

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
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->id = $config['id'];
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
