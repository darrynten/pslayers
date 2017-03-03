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
    protected $command = 'stainedglass';

    private static $validStainedGlassKinds = [
        'r',
        'random',
        'h',
        'hexagon',
        's',
        'square',
    ];

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
    protected $kind = 'random';

    /**
     * Size of cell
     *
     * @var integer
     */
    protected $size = 16;

    /**
     * Random offset amount
     * Only applies to kind=random
     *
     * @var int
     */
    protected $offset = 6;

    /**
     * Number of desired reduced colors for the output
     * Default is no color reduction
     *
     * @var integer
     */
    protected $ncolors = 32;

    /**
     * Brightness value in percent for output image
     *
     * @var integer
     */
    protected $bright = 100;

    /**
     * Color for edge or border around each cell
     * Any valid IM color
     *
     * @var string
     */
    protected $ecolor = 'black';

    /**
     * Thickness for edge or border around each cell
     * Zero means no edge or border
     *
     * @var
     */
    protected $thick = 1;

    /**
     * Random number seed value
     * If seed provided, then image will reproduce
     * Default is no seed, so that each image will be randomly different
     * Only applies to kind=random
     *
     * @var integer
     */
    protected $rseed = 12;

    public function __construct(array $config, \Imagick $image)
    {
        // Perform any custom validation
        if (isset($config['kind'])) {
            self::isValidStainedGlassKind($config['kind']);
        }

        parent::__construct($config, $image);
    }

    public static function isValidStainedGlassKind($kind)
    {
        if (!in_array($kind, self::$validStainedGlassKinds)) {
            throw new PslayersException('Invalid stained glass kind.');
        }
    }
}
