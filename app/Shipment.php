<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public const PENDING = 'pending';
    public const SHIPPED = 'shipped';

    protected $guarded = [];

    public function order(){
        return $this->belongsTo(\App\Order::class);
    }
}
