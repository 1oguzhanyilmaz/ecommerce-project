<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $guarded = [];

    public const UPLOAD_DIR = 'uploads';
    public const SMALL = '135x141';
    public const MEDIUM = '312x400';
    public const LARGE = '600x656';
    public const EXTRA_LARGE = '1125x1200';

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
