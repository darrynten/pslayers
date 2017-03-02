<?php

namespace DarrynTen\Pslayers\Filters\Filter\Fred;

use DarrynTen\Pslayers\Filters\BaseFilter;

/**
 * Pslayers Blank Filter
 *
 * @category Filter
 * @package  Pslayers
 * @author   Dmitry Semenov <mxnr@upwork.com>
 * @license  MIT <https://github.com/darrynten/psfilters/LICENSE>
 * @link     https://github.com/darrynten/psfilters
 */
class StainedGlassFilter extends BaseFilter
{
    const SCRIPT_PATH = __DIR__.'/../../../vendor/mxnr/imagic-scripts/bin/stainedglass';

    /**
     * Kind of stainedglass cell shape; choices are: square (or s), hexagon (or h), random (or r)
     *
     * @var string
     */
    private $kind = 'random';

    /**
     * Size of cell
     *
     * @var integer
     */
    private $size = 16;

    /**
     * Random offset amount
     * Only applies to kind=random
     *
     * @var int
     */
    private $offset = 6;

    /**
     * Number of desired reduced colors for the output
     * Default is no color reduction
     *
     * @var integer
     */
    private $ncolors;

    /**
     * Brightness value in percent for output image
     *
     * @var integer
     */
    private $bright = 100;

    /**
     * Color for edge or border around each cell
     * Any valid IM color
     *
     * @var string
     */
    private $ecolor = 'black';

    /**
     * Thickness for edge or border around each cell
     * Zero means no edge or border
     *
     * @var
     */
    private $thick = 1;

    /**
     * Random number seed value
     * If seed provided, then image will reproduce
     * Default is no seed, so that each image will be randomly different
     * Only applies to kind=random
     *
     * @var integer
     */
    private $rseed;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        // Bind existing properties from config values
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
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
        ];
    }

    /**
     * @param string $imagePath rendered image path
     *
     * @return string
     */
    public function render($imagePath)
    {
        return exec(
            sprintf(
                 '%s -k %s -s %s -o %s -n %s -b %s -e %s -t %s -r %s %s',
                self::SCRIPT_PATH,
                $this->kind,
                $this->size,
                $this->offset,
                $this->ncolors,
                $this->bright,
                $this->ecolor,
                $this->thick,
                $this->rseed,
                $imagePath
            )
        );
    }
}
