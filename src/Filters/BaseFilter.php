<?php

namespace DarrynTen\Pslayers\Filters;

use DarrynTen\Pslayers\PslayersException;

/**
 * Pslayers Filter Item
 *
 * @category Filter
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/psfilters/LICENSE>
 * @link     https://github.com/darrynten/psfilters
 */
abstract class BaseFilter implements FilterInterface
{
    /**
     * ID
     *
     * Unique identifier for this filter
     *
     * @var string $id
     */
    public $id;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (!isset($config['id'])) {
            throw new PslayersException('No ID Set for Filter');
        }

        $this->id = $config['id'];
    }

    /**
     * Returns a JSON representation of the filter
     *
     * @return string
     */
    public function getFilterDetailsJson()
    {
        return json_encode($this->getFilterDetailsArray());
    }
}
