<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public static function statuses(){
        return [
            1 => 'active',
            0 => 'inactive',
        ];
    }

    public function status_label(){
        $statuses = $this->statuses();

        return isset($this->status) ? $statuses[$this->status] : null;
    }

    public static function types(){
        return [
            'simple' => 'Simple',
            'configurable' => 'Configurable',
        ];
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
                        ->where('parent_id', NULL);
    }

    function price_label(){
        return ($this->variants->count() > 0) ? $this->variants->first()->price : $this->price;
    }

    public function configurable(){
        return $this->type == 'configurable';
    }

    public function simple(){
        return $this->type == 'simple';
    }
}
