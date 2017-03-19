<?php

namespace DarrynTen\Pslayers\Filters\Filter\Fred;

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
abstract class FredBaseFilter extends BaseFilter
{
    // Path to the bash files
    const FRED_COMPOSER_PACKAGE = 'mxnr/imagic-scripts';

    /**
     * The command switch map
     *
     * This allows an easy way of implementing the plugins with a
     * consistent structure that is somewhat robust
     *
     * @var array $switchMap
     */
    protected $switchMap;

    /**
     * Construct
     *
     * The way these filters work is via a "switch map" which describes
     * the plugin in a structured fashion so as to match the executables
     * switches.
     *
     * The rules are quite strict - no defaults and no optionals. We
     * check to make sure every option is being sent in the config and
     * also ensuring nothing is missing from the config as described
     * by the particular plugin.
     *
     * We load an array with a copy of the switch map and unset as we
     * set the properties. If we have an empty array at the end then we
     * know we have successfully set all config options.
     *
     * It is important for the pluings themselves to do extensive
     * validation within their __construct before passing the config
     * down to its parent.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $required = $this->switchMap;
        $required['id'] = true;

        // Bind existing properties from config values
        foreach ($config as $key => $value) {
            // You may only provide supported variables
            if (property_exists($this, $key) &&
                (
                    // id is not set in the map it is standard
                    $key === 'id' ||
                    array_key_exists($key, $this->switchMap)
                )
            ) {
                $this->{$key} = $value;
                // Unset the tracking array key
                unset($required[$key]);
            } else {
                throw new PslayersException('Invalid filter configuration. You may only provide valid filter options.');
            }
        }

        // If we still have entries then we have not provided everything
        if ($required) {
            throw new PslayersException('Missing configuration options. You must provide a valid value for every possible property.');
        }
    }

    /**
     * Returns an representation of the filter
     *
     * It uses the switch map to do so, and includes the ID
     *
     * @return array
     */
    public function getFilterDetailsArray()
    {
        // ID is not part of the switch map so must be added
        $return = [
            'id' => $this->id
        ];

        foreach ($this->switchMap as $key => $value) {
            $return[$key] = $this->{$key};
        }

        return $return;
    }

    public function render()
    {
        if ($this->image === null) {
            throw new PslayersException('Render without image set.');
        }

        // We can't use the same file for this
        $tempFileIn = tmpfile();

        // Write the existing image to the temp file
        fwrite($tempFileIn, $this->image->getImageBlob());

        $tempPathIn = stream_get_meta_data($tempFileIn)['uri'];

        // Build the command - first is the command name
        $execute = sprintf('%s ', getcwd() . '/vendor/' . self::FRED_COMPOSER_PACKAGE . '/bin/' . $this->command);

        // Then each switch
        foreach ($this->switchMap as $key => $value) {
            $string = sprintf('-%s %s ', $value, $this->{$key});
            $execute .= $string;
        }

        // Then the in file
        $inPath = sprintf('%s ', $tempPathIn);
        $execute .= $inPath;

        $tempFileOut = tmpfile();
        // There is a weird bug where the temp file vanishes too soon
        $tempPathOut = stream_get_meta_data($tempFileOut)['uri'] . '.png';

        // And the out file
        $outPath = sprintf('%s ', $tempPathOut);
        $execute .= $outPath;

        // Run
        $process = new Process(trim($execute));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->image->readImage($tempPathOut);
        unlink($tempPathOut);

        return $process->getOutput();
    }
}
