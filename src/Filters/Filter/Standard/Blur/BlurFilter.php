<?php

namespace DarrynTen\Pslayers\Filters\Filter;

use DarrynTen\Pslayers\Filters\BaseFilter;

/**
 * Pslayers Blur Filter
 *
 * @category Standard Filter
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/psfilters/LICENSE>
 * @link     https://github.com/darrynten/psfilters
 */
class BlurFilter extends BaseFilter
{
    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * Returns an representation of the filter
     *
     * @return array
     */
    public function render()
    {
        //
    }
}
