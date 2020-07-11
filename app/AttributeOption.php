<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    protected $guarded = [];

    public function attribute(){
        return $this->belongsTo('App\Attribute');
    }
}
