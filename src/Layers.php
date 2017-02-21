<?php

namespace DarrynTen\Pslayers;

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
     * @var string $collection
     */
    private $collection;

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
     * Get the array representation of the collection
     *
     * @return array
     */
    public function getLayersArray()
    {
        return [
            'contentItems' => $this->collection
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

    /**
     * Add a content item to the collection
     *
     * @param ContentItem  $contentItem
     */
    public function addLayerToCollection(Layer $layer)
    {
        $this->collection[] = $layer->getLayerDetailsArray();
    }
}
