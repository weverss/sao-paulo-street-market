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
        if (!$request->isJson()) {
            abort($response::HTTP_BAD_REQUEST, 'Content must be application/json type');
        }

        $streetMarket->fill($request->all());
        $streetMarket->registration_code = $request->registration_code;
        $streetMarket->save();

        $locationPath = sprintf('%s/%s', $request->path(), $streetMarket->registration_code);
        $locationUri = url($locationPath);

        return response()->make('', $response::HTTP_CREATED)->header('Location', $locationUri);
    }

    public function show(StreetMarket $streetMarket)
    {
        return $streetMarket;
    }

    public function update(StreetMarket $streetMarket, Request $request, Response $response)
    {
        if (!$request->isJson()) {
            abort($response::HTTP_BAD_REQUEST, 'Content must be application/json type');
        }

        $streetMarket->fill($request->all());
        $streetMarket->save();

        $locationUri = url($request->path());

        return response()->make('', $response::HTTP_NO_CONTENT)->header('Location', $locationUri);
    }

    public function destroy(StreetMarket $streetMarket, Response $response)
    {
        $streetMarket->delete();

        return response()->make('', $response::HTTP_NO_CONTENT);
    }
}
