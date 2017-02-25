<?php

namespace DarrynTen\Pslayers\Layers;

/**
 * Pslayers Layer collection model
 *
 * @category Collection
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class LayerCollection
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
     * Construct
     *
     * @return object
     */
    public function __construct()
    {
        $this->collection = [];
    }

    /**
     * Add a content item to the collection
     *
     * NB At the stage inserting on the same layer
     * index OVERWRITES that layer. This is purely for the sake
     * of really not wanting to deal with z-indexing sorting stuff.
     *
     * @param BaseLayer $layer The layer to add to the stack
     * @param float $index The index layer
     */
    public function addLayerToCollection(BaseLayer $layer, int $index)
    {
        $this->collection[$index] = $layer;
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
    public function getLayersJson(): string
    {
        return json_encode($this->getLayersArray());
    }
}
