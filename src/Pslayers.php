<?php

namespace DarrynTen\Pslayers;

use DarrynTen\Pslayers\Config\Config;
use DarrynTen\Pslayers\Layers\BaseLayer;
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
     * @var \Imagick $masterCanvas
     */
    private $masterCanvas;

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
     * Write path
     *
     * Where to output the file (if you want to output it)
     *
     * @var string|null $outputPath
     */
    public $outputPath;

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
        $this->masterCanvas = new \Imagick();
        $this->masterCanvas->newImage($config['width'], $config['height'], new \ImagickPixel('rgba(255, 255, 255, 0)'));
        $this->masterCanvas->setImageFormat('png');
    }

    /**
     * Adds a layer to the root collection
     *
     * @param BaseLayer $layer The layer to add
     * @param int $index The z-index to assign to
     */
    public function addLayer(BaseLayer $layer, int $index)
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
        foreach ($this->layers->collection as $layer) {
            $this->masterCanvas->compositeImage($layer->render(), $layer->composite, 0, 0);
        }

        if ($this->config->outputPath !== null) {
            $this->masterCanvas->writeImage($this->config->outputPath);
        }

        return $this->masterCanvas;
    }
}
