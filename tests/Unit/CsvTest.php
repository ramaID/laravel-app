<?php

namespace Tests\Unit;

use Support\Csv;
use Tests\TestCase;

class CsvTest extends TestCase
{
    public function test_can_read_each_row()
    {
        $lastRow = null;
        $csvReader = new Csv(resource_path('stocks/sample.csv'));
        $csvReader->row(function ($row) use (&$lastRow) {
            $lastRow = $row;
        });

        $this->assertIsArray($lastRow);
    }
}
