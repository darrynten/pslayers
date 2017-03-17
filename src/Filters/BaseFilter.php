<?php

namespace DarrynTen\Pslayers\Filters;

use DarrynTen\Pslayers\Exceptions\PslayersException;

/**
 * Pslayers Filter Item
 *
 * @category Filter
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
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
     * An Imagick object.
     *
     * The image we're filtering
     */
    protected $image;

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

    public function setImage(\Imagick $image)
    {
        $imageSize = $image->getSize();

        if (0 === $imageSize['columns'] && 0 === $imageSize['rows']) {
            throw new PslayersException('Empty Imagick object provided');
        }

        $this->image = $image;
        $this->image->setImageFormat('png');
    }

    public function getImage()
    {
        return $this->image;
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
