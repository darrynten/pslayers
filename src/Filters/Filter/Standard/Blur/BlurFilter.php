<?php

namespace DarrynTen\Pslayers\Filters\Filter\Standard\Blur;

use DarrynTen\Pslayers\Filters\BaseFilter;
use DarrynTen\Pslayers\Exceptions\PslayersException;

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
    public $radius;
    public $sigma;
    public $channel;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!isset($config['radius'])) {
            throw new PslayersException('Missing radius for blur filter');
        }

        if (!isset($config['sigma'])) {
            throw new PslayersException('Missing sigma for blur filter');
        }

        if (!isset($config['channel'])) {
            $config['channel'] = \Imagick::CHANNEL_ALL;
        }

        $this->radius = $config['radius'];
        $this->sigma = $config['sigma'];
        $this->channel = $config['channel'];
    }

    /**
     * Returns an representation of the filter
     *
     * @return array
     */
    public function render()
    {
        $this->image->blurImage($this->radius, $this->sigma, $this->channel);
    }

    /**
     * Returns an representation of the filter
     *
     * @return array
     */
    public function getFilterDetailsArray()
    {
        return [
            'id' => $this->id,
            'radius' => $this->radius,
            'sigma' => $this->sigma,
            'channel' => $this->channel,
        ];
    }
}
