<?php

namespace DarrynTen\Pslayers\Layers\Layer;

use DarrynTen\Pslayers\Layers\BaseLayer;
use DarrynTen\Pslayers\Layers\LayerCollection;

/**
 * Pslayers Group Layer
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class GroupLayer extends BaseLayer
{
    /**
     * Layers
     *
     * @var LayerCollection $group
     */
    public $group;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (!empty($config['group']) && $config['group'] instanceof LayerCollection) {
            $this->group = $config['group'];
        } else {
            $this->group = new LayerCollection();
        }

        parent::__construct($config);
    }

    /**
     * Adds a layer to the group
     *
     * @param BaseLayer $layer The layer to add
     * @param int $index The z-index to assign to
     */
    public function addLayer(BaseLayer $layer, int $index)
    {
        $this->group->addLayerToCollection($layer, $index);
    }


    /**
     * Returns an representation of the layer
     *
     * @return array
     */
    public function getLayerDetailsArray(): array
    {
        return [
            'id' => $this->id,
            'opacity' => $this->opacity(),
            'width' => $this->width(),
            'height' => $this->height(),
            'positionX' => $this->positionX(),
            'positionY' => $this->positionY(),
            'composite' => $this->composite(),
            'group' => $this->group,
        ];
    }

    public function render()
    {
        foreach ($this->group->collection as $layer) {
            $this->canvas->compositeImage($layer->render(), $layer->composite, 0, 0);
        }

        return $this->canvas;
    }
}
