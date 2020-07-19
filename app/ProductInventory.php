<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    protected $guarded = [];

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public static function reduceStock($productId, $qty){
        $inventory = self::where('product_id', $productId)->firstOrFail();

        if ($inventory->qty < $qty) {
            $product = Product::findOrFail($productId);
            // throw new \App\Exceptions\OutOfStockException('The product '. $product->sku .' is out of stock');
            return $product->name . ' out of stock.';
        }

        $inventory->qty = $inventory->qty - $qty;
        $inventory->save();
    }

    public static function increaseStock($productId, $qty){
        $inventory = self::where('product_id', $productId)->firstOrFail();
        $inventory->qty = $inventory->qty + $qty;
        $inventory->save();
    }
}
