<?php

namespace Tivit\StreetMarket;

use Illuminate\Database\Eloquent\Model;

class StreetMarket extends Model
{
    protected $fillable = [
        'street_market_name',
        'street_name',
        'street_number',
        'neighborhood',
        'landmark',
        'latitude',
        'longitude',
        'district_code',
        'district_name',
        'council_code',
        'council_name',
        'five_area_region',
        'eight_area_region',
        'census_tract',
        'census_tract_group',
    ];

    public function getStreetNumberAttribute()
    {
        $streetNumber = $this->attributes['street_number'];

        if(is_numeric($streetNumber)) {
            return intval($streetNumber);
        }

        return $streetNumber;
    }
}
