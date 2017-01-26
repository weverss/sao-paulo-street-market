<?php

namespace Tivit\StreetMarket\Http\Controllers;

use Illuminate\Http\Request;
use Tivit\StreetMarket\StreetMarket;

class StreetMarketController extends Controller
{
    public function index()
    {
        return StreetMarket::all();
    }
}
