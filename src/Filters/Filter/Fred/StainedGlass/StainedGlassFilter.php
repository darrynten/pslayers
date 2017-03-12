<?php

namespace DarrynTen\Pslayers\Filters\Filter\Fred\StainedGlass;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use DarrynTen\Pslayers\Filters\Filter\Fred\FredBaseFilter;
use DarrynTen\Pslayers\Exceptions\PslayersException;

/**
 * Pslayers Blank Filter
 *
 * @category Filter
 * @package  Pslayers
 * @author   Dmitry Semenov <mxnr@upwork.com>
 * @license  MIT <https://github.com/darrynten/psfilters/LICENSE>
 * @link     https://github.com/darrynten/psfilters
 */
class StainedGlassFilter extends FredBaseFilter
{
    /**
     * The Fred command to run. The path to the bash script is
     * defined in the base fred filter class.
     *
     * @var string $command
     */
    protected $command = 'stainedglass';

    /**
     * Valid options for stained glass types.
     *
     * Used by the validation method in this class
     *
     * @var array $validStainedGlassKinds
     */
    private static $validStainedGlassKinds = [
        'r',
        'random',
        'h',
        'hexagon',
        's',
        'square',
    ];

    /**
     * The switch map
     *
     * Defines the construct of the renderer and all validation.
     *
     * @param array $switchMap
     */
    protected $switchMap = [
        'kind' => 'k',
        'size' => 's',
        'offset' => 'o',
        'ncolors' => 'n',
        'bright' => 'b',
        'ecolor' => 'e',
        'thick' => 't',
        'rseed' => 'r',
    ];

    /**
     * Kind of stainedglass cell shape; choices are: square (or s), hexagon (or h), random (or r)
     *
     * @var string
     */
    protected $kind;

    /**
     * Size of cell
     *
     * @var integer
     */
    protected $size;

    /**
     * Random offset amount
     * Only applies to kind=random
     *
     * @var integer
     */
    protected $offset;

    /**
     * Number of desired reduced colors for the output
     * Default is no color reduction
     *
     * @var integer
     */
    protected $ncolors;

    /**
     * Brightness value in percent for output image
     *
     * @var integer
     */
    protected $bright;

    /**
     * Color for edge or border around each cell
     * Any valid IM color
     *
     * @var string
     */
    protected $ecolor;

    /**
     * Thickness for edge or border around each cell
     * Zero means no edge or border
     *
     * @var integer
     */
    protected $thick;

    /**
     * Random number seed value
     * If seed provided, then image will reproduce
     * Default is no seed, so that each image will be randomly different
     * Only applies to kind=random
     *
     * @var integer
     */
    protected $rseed;

    /**
     * StainedGlassFilter constructor.
     *
     * @param array $config
     * @param \Imagick $image
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        // Perform any custom validation
        if (isset($config['kind'])) {
            self::isValidStainedGlassKind($config['kind']);
        }
    }

    /**
     * @param $kind
     *
     * @throws PslayersException
     */
    public static function isValidStainedGlassKind($kind)
    {
        if (!in_array($kind, self::$validStainedGlassKinds)) {
            throw new PslayersException('Invalid stained glass kind.');
        }
    }
}
