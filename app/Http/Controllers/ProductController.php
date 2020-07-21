<?php

namespace App\Http\Controllers;

use App\AttributeOption;
use App\Category;
use App\Product;
use App\ProductAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function products(Request $request){
        $products = Product::active();

        // filter product here
        $products = $this->_searchProducts($products, $request);
        $products = $this->_filterProductsByPriceRange($products, $request);
        // $products = $this->_filterProductsByAttribute($products, $request);
        // $products = $this->_sortProducts($products, $request);

        $products = $products->paginate(6);

        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        // url => value
        $breadcrumbs = [
            'products' => 'products',
        ];
        return view('front.pages.product-list', compact('products','minPrice','maxPrice','breadcrumbs'));
    }

    public function productDetails($slug){
        $product = Product::active()->where('slug', $slug)->firstOrFail();
        if (!$product){
            return redirect()->route('products');
        }

        // check if product is configurable and send attributes
        $attributes = [
            'color' => [
                'black',
                'white',
            ],
            'size' => [
                'S',
                'M',
                'L',
            ]
        ];

        $breadcrumbs = [
            'products' => 'products',
            'notNecessary' => $product->name,
        ];

        return view('front.pages.product-details', compact('product','attributes','breadcrumbs'));
    }

    public function categoryProducts($slug){
        $category = Category::where('slug', $slug)->first();
        $products = $category->products;

        $breadcrumbs = [
            'products' => 'products',
            'notNecessary' => $category->name,
        ];

        return view('front.pages.product-list', compact('products','breadcrumbs'));
    }

    private function _searchProducts($products, $request){
        if ($q = $request->query('q')) {
            $q = str_replace('-', ' ', Str::slug($q));
            $products = $products->where('name', 'like', '%'.$q.'%');
        }
        if ($categorySlug = $request->query('category')) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();

            $childIds = Category::childIds($category->id);
            $categoryIds = array_merge([$category->id], $childIds);

            $products = $products->whereHas(
                'categories',
                function ($query) use ($categoryIds) {
                    $query->whereIn('categories.id', $categoryIds);
                }
            );
        }

        return $products;
    }

    private function _filterProductsByPriceRange($products, $request){
        $lowPrice = null;
        $highPrice = null;

        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        $lowPrice = (!is_null($request->input('minPrice'))) ? (float)$request->input('minPrice') : $minPrice;
        $highPrice = (!is_null($request->input('maxPrice'))) ? (float)$request->input('maxPrice') : $maxPrice;

        if ($lowPrice && $highPrice) {
            $products = $products->where('price', '>=', $lowPrice)
                ->where('price', '<=', $highPrice)
                ->orWhere('price', $request->input('price'));
        }

        return $products;
    }

    private function _filterProductsByAttribute($products, $request){
        if ($attributeOptionID = $request->query('option')) {
            $attributeOption = AttributeOption::findOrFail($attributeOptionID);

            $products = $products->whereHas(
                'ProductAttributeValues',
                function ($query) use ($attributeOption) {
                    $query->where('attribute_id', $attributeOption->attribute_id)
                        ->where('text_value', $attributeOption->name);
                }
            );
        }

        return $products;
    }

    private function _sortProducts($products, $request){
        if ($sort = preg_replace('/\s+/', '', $request->query('sort'))) {
            $availableSorts = ['price', 'created_at'];
            $availableOrder = ['asc', 'desc'];
            $sortAndOrder = explode('-', $sort);

            $sortBy = strtolower($sortAndOrder[0]);
            $orderBy = strtolower($sortAndOrder[1]);

            if (in_array($sortBy, $availableSorts) && in_array($orderBy, $availableOrder)) {
                $products = $products->orderBy($sortBy, $orderBy);
            }

            $this->data['selectedSort'] = url('products?sort='. $sort);
        }

        return $products;
    }
}
