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
abstract class FredBaseFilter extends BaseFilter implements FredFilterInterface
{
    // Path to the bash files
    const BIN_FOLDER = __DIR__.'/../../../../vendor/mxnr/imagic-scripts/bin';

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
    public function __construct(array $config, \Imagick $image)
    {
        parent::__construct($config, $image);

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
        // We can't use the same file for this
        $tempFileIn = tmpfile();
        $tempFileOut = tmpfile();

        // Write the existing image to the temp file
        fwrite($tempFileIn, $this->image->getImageBlob());

        $tempPathIn = stream_get_meta_data($tempFileIn)['uri'];
        $tempPathOut = stream_get_meta_data($tempFileOut)['uri'];

        // Build the command - first is the command name
        $execute = sprintf('%s ', self::BIN_FOLDER . '/' . $this->command);

        // Then each switch
        foreach ($this->switchMap as $key => $value) {
            $exectute .= sprintf('-%s %s ', $value, $this->{$key});
        }

        // Then the in file
        $execute .= sprintf('%s ', $tempPathIn);

        // And the out file
        $execute .= sprintf('%s ', $tempPathOut);

        // Run
        $process = new Process($execute);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Load the new image back
        $this->image->readImage($tempPathOut);

        return $process->getOutput();
    }
}
