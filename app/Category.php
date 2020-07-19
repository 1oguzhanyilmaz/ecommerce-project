<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function childs() {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function parent() {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function products(){
        return $this->belongsToMany('App\Product', 'category_product')->where('status', 1)->where('parent_id', null);
    }

    public function scopeParentCategories($query){
        return $query->where('parent_id', 0);
    }

    public static function childIds($parentId = 0){
        $categories = Category::select('id','name','parent_id')->where('parent_id', $parentId)->get()->toArray();

        $childIds = [];
        if(!empty($categories)){
            foreach($categories as $category){
                $childIds[] = $category['id'];
                $childIds = array_merge($childIds, Category::childIds($category['id']));
            }
        }

        return $childIds;
    }
}
