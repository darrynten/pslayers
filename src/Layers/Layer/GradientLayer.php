<?php

namespace DarrynTen\Pslayers\Layers\Layer;

use DarrynTen\Pslayers\Layers\BaseLayer;
use DarrynTen\Pslayers\Validators\ColourValidator;
use DarrynTen\Pslayers\Exceptions\PslayersException;

/**
 * Pslayers Gradient Layer
 *
 * TODO very incomplete
 *
 * @category Layer
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */
class GradientLayer extends BaseLayer
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
        if (!isset($config['startColour']) || !isset($config['endColour'])) {
            throw new PslayersException('Missing Gradient Layer start and end colour.');
        }

        $this->startColour(
            !empty($config['startColour']) ? $config['startColour'] : '#FFF'
        );

        $this->endColour(
            !empty($config['endColour']) ? $config['endColour'] : '#000'
        );

        $this->canvas->setImageFormat('png32');
        $this->canvas->newPseudoImage($config['width'], $config['height'], sprintf('gradient: %s-%s', $config['startColour'], $config['endColour']));
    }

    /**
     * Get and set the start colour
     *
     * @param null|int $colour The colour
     *
     * @return boolean|string
     */
    public function startColour(string $colour = null)
    {
        ColourValidator::isValidColour($colour);

        if ($colour === null) {
            return $this->startColour;
        }

        return $this->startColour = $colour;
    }

    /**
     * Get and set the end colour
     *
     * @param null|int $colour The end colour
     *
     * @return boolean|string
     */
    public function endColour(string $colour = null)
    {
        ColourValidator::isValidColour($colour);

        if ($colour === null) {
            return $this->endColour;
        }

        return $this->endColour = $colour;
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
            'startColour' => $this->startColour(),
            'endColour' => $this->endColour(),
        ];
    }
}
