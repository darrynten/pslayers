<?php

namespace DarrynTen\Pslayers;

use DarrynTen\Pslayers\Layers\LayerCollection;

/**
 * Pslayers
 *
 * @category Library
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class Pslayers
{
    /**
     * Imagick Instance
     *
     * @var \Imagick $imagick
     */
    private $imagick;

    /**
     * Hold the config option
     *
     * @var Config $config
     */
    public $config;

    /**
     * Holds the layers
     *
     * @var LayerCollection $layers
     */
    public $layers;

    /**
     * Construct
     *
     * Bootstraps the config and the cache, then loads the request handler
     *
     * @param array $config Configuration options
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
        $this->layers = new LayerCollection();
        $this->imagick = new \Imagick();
    }

    /**
     * Adds a layer to the root collection
     *
     * @param BaseLayer $layer The layer to add
     * @param int $index The z-index to assign to
     */
    public function addLayer($layer, int $index)
    {
        $this->layers->addLayerToCollection($layer, $index);
    }

    /**
     * Master render function
     *
     * Render and composite all the renders
     */
    public function render()
    {
        // TODO
        return;
    }
}
