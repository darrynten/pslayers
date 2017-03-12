<?php

namespace DarrynTen\Pslayers\Layers\Layer;

use DarrynTen\Pslayers\Layers\BaseLayer;
use DarrynTen\Pslayers\Validators\ColourValidator;
use DarrynTen\Pslayers\Exceptions\PslayersException;

/**
 * Pslayers Pattern Layer
 *
 * TODO very incomplete
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class PatternLayer extends BaseLayer
{
    /**
     * Start Colour
     *
     * @var string $colour
     */
    public $startColour;

    /**
     * End Colour
     *
     * @var string $colour
     */
    public $endColour;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        if (!isset($config['pattern'])) {
            throw new PslayersException('Missing Pattern Layer pattern.');
        }

        if (!isset($config['scale'])) {
            throw new PslayersException('Missing Pattern Layer scale factor.');
        }

        if (!isset($config['scaleFilter'])) {
            throw new PslayersException('Missing Pattern Layer scale filter.');
        }

        $this->pattern($config['pattern']);
        $this->scale($config['scale']);

        $scaleWidth = $config['width'] / $config['scale'];
        $scaleHeight = $config['height'] / $config['scale'];

        $this->canvas->newPseudoImage($scaleWidth, $scaleHeight, sprintf('pattern:%s', $this->pattern));

        $this->canvas->resizeImage($config['width'], $config['height'], $config['scaleFilter'], 1);
    }

    /**
     * Get and set the pattern
     *
     * @param null|int $pattern
     *
     * @return boolean|string
     */
    public function pattern(string $pattern = null)
    {
        if ($pattern === null) {
            return $this->pattern;
        }

        return $this->pattern = $pattern;
    }

    /**
     * Get and set the end colour
     *
     * @param null|int $colour The end colour
     *
     * @return boolean|string
     */
    public function scale(int $scale = null)
    {
        if ($scale === null) {
            return $this->scale;
        }

        return $this->scale = $scale;
    }

    /**
     * Returns an representation of the layer
     *
     * @return array
     */
    public function getLayerDetailsArray()
    {
        return [
            'id' => $this->id,
            'opacity' => $this->opacity(),
            'width' => $this->width(),
            'height' => $this->height(),
            'positionX' => $this->positionX(),
            'positionY' => $this->positionY(),
            'composite' => $this->composite(),
            'pattern' => $this->pattern(),
            'scale' => $this->scale(),
        ];
    }
}
