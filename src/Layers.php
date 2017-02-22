<?php

namespace DarrynTen\Pslayers;

use Imagick;

/**
 * Pslayers Layers collection model
 *
 * @category Model
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class Layers
{
    /**
     * Layer Collection
     *
     * Container of layers
     *
     * @var array $collection
     */
    public $collection;

    /**
     * Layer Composites
     *
     * Currently only a mix mode but can be so much more
     *
     * Imagick::COMPOSITE_DEFAULT is an example
     *
     * @var $composites
     */
    public $composites;

    /**
     * Construct
     *
     * @return object
     */
    public function __construct()
    {
        $this->collection = [];
        $this->composites = [];
    }

    /**
     * Add a content item to the collection
     *
     * NB At the stage inserting on the same layer
     * index OVERWRITES that layer. This is purely for the sake
     * of really not wanting to deal with z-indexing sorting stuff.
     *
     * @param Layer $layer The layer to add to the stack
     * @param float $index The index layer
     * @param int $composite The Imagick composition constant
     */
    public function addLayerToCollection(Layer $layer, int $index, int $composite = Imagick::COMPOSITE_DEFAULT)
    {
        $this->collection[$index] = $layer;
        $this->composites[$index] = $composite;
    }

    /**
     * Get the array representation of the collection
     *
     * @return array
     */
    public function getLayersArray()
    {
        return [
            'layers' => $this->collection
        ];
    }

    /**
     * Get the json representation of the collection
     *
     * @return string
     */
    public function getLayersJson()
    {
        return json_encode($this->getLayersArray());
    }
}
