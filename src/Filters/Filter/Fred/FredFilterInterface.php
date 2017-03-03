<?php

namespace DarrynTen\Pslayers\Filters\Filter\Fred;

/**
 * Pslayers Filter Interface
 *
 * @category Filter
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/psfilters/LICENSE>
 * @link     https://github.com/darrynten/psfilters
 */
interface FredFilterInterface
{
    /**
     * Each filter adds its own things and must include
     * all the things. Not the best design.
     *
     * @var string $id
     */
    public function getFilterDetailsArray();

    public function render();
}
