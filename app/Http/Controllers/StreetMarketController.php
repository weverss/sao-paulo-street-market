<?php

namespace Tivit\StreetMarket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tivit\StreetMarket\StreetMarket;

class StreetMarketController extends Controller
{
    public function index(StreetMarket $streetMarket, Request $request)
    {
        $query = $streetMarket::query();

        if ($request->has('q')) {
            $q = sprintf('%%%s%%', $request->input('q'));

            $query->where('district_name', 'like', $q);
            $query->orWhere('five_area_region', 'like', $q);
            $query->orWhere('street_market_name', 'like', $q);
            $query->orWhere('neighborhood', 'like', $q);
        }

        return $query->paginate();
    }

    public function store(StreetMarket $streetMarket, Request $request, Response $response)
    {
        $streetMarket->fill($request->all());
        $streetMarket->registration_code = $request->registration_code;

        if($streetMarket->save()) {
            return $response->make('', $response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->make('', $response::HTTP_CREATED);
    }

    public function show(StreetMarket $streetMarket)
    {
        return $streetMarket;
    }

    public function update(StreetMarket $streetMarket)
    {
        $streetMarket->fill($request->all());

        $streetMarket->save();
    }

    public function destroy(StreetMarket $streetMarket)
    {
        $streetMarket->delete();
    }
}
