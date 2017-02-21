<?php

namespace DarrynTen\Pslayers\Tests\Pslayers;

use DarrynTen\Pslayers\PslayersException;
use DarrynTen\Pslayers\Pslayers;
use PHPUnit_Framework_TestCase;

class PslayersExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testJsonException()
    {
        $this->expectException(PslayersException::class);

        throw new PslayersException(
            json_encode(
                [
                    'errors' => [
                        'code' => 1,
                    ],
                    'status' => 10022,
                    'title' => 'Error',
                    'detail' => 'Error Details',
                ]
            )
        );
    }
}
