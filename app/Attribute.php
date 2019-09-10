<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public function getChildren()
    {
        return $this->hasMany(AttributeChild::class);
    }
}
