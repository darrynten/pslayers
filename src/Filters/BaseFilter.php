<?php

namespace DarrynTen\Pslayers\Filters;

use DarrynTen\Pslayers\Exceptions\PslayersException;

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
     * Image
     *
     * The image we're filtering
     */
    protected $image;

    /**
     * Image Data
     *
     * The raw image data
     */
    protected $imageBlob;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config, \Imagick $image)
    {
        if (!isset($config['id'])) {
            throw new PslayersException('No ID Set for Filter');
        }

        $imageSize = $image->getSize();

        if (0 === $imageSize['columns'] && 0 === $imageSize['rows']) {
            throw new PslayersException('Empty Imagick object provided');
        }

        $this->id = $config['id'];

        $this->image = $image;
        $this->imageBlob = $image->getImageBlob();
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
