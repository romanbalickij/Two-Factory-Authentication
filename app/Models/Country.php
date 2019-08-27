<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected  $guarded = [];


    public static function createCountry($param) {
        if($param != null) {
            return $result = Country::updateOrCreate(['name' => $param])->id;
        }
        return false;
    }
}
