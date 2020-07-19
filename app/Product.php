<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public const ACTIVE = 1;
    public const INACTIVE = 2;

    public const STATUSES = [
        self::ACTIVE => 'active',
        self::INACTIVE => 'inactive',
    ];

    public const SIMPLE = 'simple';
    public const CONFIGURABLE = 'configurable';
    public const TYPES = [
        self::SIMPLE => 'Simple',
        self::CONFIGURABLE => 'Configurable',
    ];

    public static function statuses(){
        return self::STATUSES;
    }

    public function statusLabel(){
        $statuses = $this->statuses();

        return isset($this->status) ? $statuses[$this->status] : null;
    }

    public static function types(){
        return self::TYPES;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function categories(){
        return $this->belongsToMany('App\Category', 'category_product');
    }

    public function productImages(){
        return $this->hasMany('App\ProductImage')->orderBy('id', 'DESC');
    }

    public function productInventory(){
        return $this->hasOne('App\ProductInventory');
    }

    public function variants(){
        return $this->hasMany('App\Product', 'parent_id')->orderBy('price', 'ASC');
    }

    public function parent(){
        return $this->belongsTo('App\Product', 'parent_id');
    }

    public function productAttributeValues(){
        return $this->hasMany('App\ProductAttributeValue', 'parent_product_id');
    }

    public function scopeActive($query){
        return $query->where('status', 1)
                        ->where('parent_id', null);
    }

    public function scopePopular($query, $limit = 10){

    }

    public function priceLabel(){
        return ($this->variants->count() > 0) ? $this->variants->first()->price : $this->price;
    }


    public function configurable(){
        return $this->type == 'configurable';
    }

    public function simple(){
        return $this->type == 'simple';
    }
}
