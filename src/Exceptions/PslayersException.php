<?php
/**
 * Pslayers Exception
 *
 * @category Exception
 * @package  Pslayers
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/pslayers/LICENSE>
 * @link     https://github.com/darrynten/pslayers
 */

namespace DarrynTen\Pslayers\Exceptions;

use \Exception;

/**
 * Custom exception for Pslayers
 *
 * @package Pslayers
 */
class PslayersException extends Exception
{

    /**
     * @inheritdoc
     *
     * @param string    $message  The message to throw
     * @param integer   $code     The error code to throw
     * @param Exception $previous The previous exception
     */
    public function __construct(string $message = null, int $code = null, Exception $previous = null)
    {
        // Construct message from JSON if required.
        if (preg_match('/^[\[\{]\"/', $message)) {
            $messageObject = json_decode($message);
            $message = sprintf(
                '%s: %s - %s',
                $messageObject->status,
                $messageObject->title,
                $messageObject->detail
            );
            if (!empty($messageObject->errors)) {
                $message .= ' ' . serialize($messageObject->errors);
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
