<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected  $guarded = [];


    public static function createCity($param, $stateId) {
        if($param != null) {
            return City::updateOrCreate([
                'name'     => $param,
                'state_id' => $stateId,
            ]);
        }
    }
}
