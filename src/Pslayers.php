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
    private $layers;

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
