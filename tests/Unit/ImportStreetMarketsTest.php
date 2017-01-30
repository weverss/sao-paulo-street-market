<?php

namespace Tests\Unit;

use DB;
use Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImportStreetMarketsTest extends TestCase
{
    public function testHandle()
    {
        $exitCode = Artisan::call('import:street-markets', ['filepath' => base_path('tests/TestFile.csv')]);

        $this->assertEquals(0, $exitCode);
    }
}
