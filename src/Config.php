<?php

namespace DarrynTen\Pslayers;

/**
 * Pslayers Config
 *
 * @category Configuration
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class Config
{
    /**
     * The width of the image stack
     *
     * @var string $width
     */
    public $width;

    /**
     * The height of the image stack
     *
     * @var string $height
     */
    public $height;

    /**
     * Construct the config object
     *
     * @param array $config An array of configuration options
     */
    public function __construct(array $config)
    {
        // Throw exceptions on essentials
        if (empty($config['width'])) {
            throw new PslayersException('Missing Master Width');
        } else {
            $this->width = (int) $config['width'];
        }

        if (empty($config['height'])) {
            throw new PslayersException('Missing Master Height');
        } else {
            $this->height = (int) $config['height'];
        }

        // optionals
        if (!empty($config['id'])) {
            $this->id = (int) $config['id'];
        } else {
            $this->id = uniqid('pslayers', true);
        }
    }
}
