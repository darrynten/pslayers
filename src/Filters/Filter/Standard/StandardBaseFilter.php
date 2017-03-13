<?php

namespace DarrynTen\Pslayers\Filters\Filter\Standard;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use DarrynTen\Pslayers\Exceptions\PslayersException;
use DarrynTen\Pslayers\Filters\BaseFilter;

/**
 * Pslayers Filter Item
 *
 * @category Filter
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/psfilters/LICENSE>
 * @link     https://github.com/darrynten/psfilters
 */
abstract class StandardBaseFilter extends BaseFilter
{
    public function render()
    {
        if ($this->image === null) {
            throw new PslayersException('Render without image set.');
        }
    }
}
