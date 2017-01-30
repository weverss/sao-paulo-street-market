<?php

namespace Tivit\StreetMarket;

use Illuminate\Database\Eloquent\Model;

class StreetMarket extends Model
{
    protected $guarded = [
        'id',
        'registration_code',
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
