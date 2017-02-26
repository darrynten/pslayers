<?php

namespace DarrynTen\Pslayers\Tests;

use Imagick;
use DarrynTen\Pslayers\Filters\Filter\BlankFilter;

class BlankFiltersTest extends \PHPUnit_Framework_TestCase
{
    public function testNewBlankFilter()
    {
        $filter = new BlankFilter([
            'id' => 1,
        ]);

        $this->assertInstanceOf(BlankFilter::class, $filter);
        $this->assertObjectHasAttribute('id', $filter);
    }

    public function testGetFilterArray()
    {
        $expected = [
            'id' => 1,
        ];

        $filter = new BlankFilter([
            'id' => 1,
        ]);

        $this->assertEquals($expected, $filter->getFilterDetailsArray());
    }

    public function testGetBlankFilterJson()
    {
        $expected = json_encode([
            'id' => 1,
        ]);

        $filter = new BlankFilter([
            'id' => 1,
        ]);

        $this->assertEquals($expected, $filter->getFilterDetailsJson());
    }
}
