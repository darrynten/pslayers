<?php

namespace DarrynTen\Pslayers\Filters\Filter\Fred\Dice;

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
class DiceFilter extends FredBaseFilter
{
    /**
     * The Fred command to run. The path to the bash script is
     * defined in the base fred filter class.
     *
     * @var string $command
     */
    protected $command = 'dice';

    /**
     * The switch map
     *
     * Defines the construct of the renderer and all validation.
     *
     * @param array $switchMap
     */
    protected $switchMap = [
        'size' => 's',
        'percent' => 'p',
        'center' => 'c',
        'radii' => 'r',
        'rounding' => 'R',
    ];

    /**
     * Size of cell
     *
     * @var integer
     */
    protected $size;

    /**
     * Percentage of patches to randomly process
     *
     * @var integer
     */
    protected $percent;

    /**
     * x and y center of round rectangle mask
     *
     * @var string
     */
    protected $center;

    /**
     * x and y radii of mask (0,0)
     *
     * @var string
     */
    protected $radii;

    /**
     * rounding for the rectainge corner 0,0
     *
     * @var string
     */
    protected $rounding;

    // negate - not sure how to implement...

    /**
     * Colour of the edges
     *
     * @var string
     */
    protected $ecolor;

    /**
     * DiceFilter constructor.
     *
     * @param array $config
     * @param \Imagick $image
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }
}
