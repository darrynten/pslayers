<?php

namespace DarrynTen\Pslayers\Filters;

/**
 * Pslayers Filter collection model
 *
 * @category Collection
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class FilterCollection
{
    /**
     * Filter Collection
     *
     * Container of filters
     *
     * @var array $collection
     */
    public $collection;

    /**
     * Construct
     *
     * @return object
     */
    public function __construct($filters = null)
    {
        $this->collection = $filters ? $filters : [];
    }

    /**
     * Add a content item to the collection
     *
     * NB At the stage inserting on the same filter
     * index OVERWRITES that filter. This is purely for the sake
     * of really not wanting to deal with z-indexing sorting stuff.
     *
     * @param BaseFilter $filter The filter to add to the stack
     * @param float $index The index filter
     */
    public function addFilterToCollection(BaseFilter $filter, int $index)
    {
        $this->collection[$index] = $filter;
    }

    /**
     * Get the array representation of the collection
     *
     * @return array
     */
    public function getFiltersArray()
    {
        return [
            'filters' => $this->collection
        ];
    }

    /**
     * Get the json representation of the collection
     *
     * @return string
     */
    public function getFiltersJson(): string
    {
        return json_encode($this->getFiltersArray());
    }
}
