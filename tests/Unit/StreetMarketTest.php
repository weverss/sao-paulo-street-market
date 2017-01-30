<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tivit\StreetMarket\StreetMarket;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StreetMarketTest extends TestCase
{
    public function testStreetNumberCasting()
    {
        $streetMarket = new StreetMarket();
        $streetMarket->street_number = '123';

        $this->assertTrue(is_int($streetMarket->street_number));

        $streetMarket->street_number = 'S/N';

        $this->assertEquals('S/N', $streetMarket->street_number);
    }
}
