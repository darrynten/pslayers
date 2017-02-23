<?php

namespace DarrynTen\Pslayers\Layers;

/**
 * Pslayers Layer Interface
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
interface LayerInterface
{
    /**
     * Each layer adds its own things and must include
     * all the things. Not the best design.
     *
     * @var string $id
     */
    public function getLayerDetailsArray();
}
