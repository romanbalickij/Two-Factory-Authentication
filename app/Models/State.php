<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected  $guarded = [];


    public static function createState($param, $countryId) {
        if($param != null) {
            return State::updateOrCreate([
                'name'     => $param,
                'country_id' => $countryId,
            ])->id;
        }
    }
}
