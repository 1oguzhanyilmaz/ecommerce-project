<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct(){
        // $this->middleware('auth');
        parent::__construct();
    }

    public function products(){
        $slug = 'slug';

        return view('front.pages.home', compact('slug'));
    }

    public function productDetails(Request $request){
//        $product = Product::where('slug', $request->input('slug'))->firstOrFail();
        $product = Product::first();

        return view('front.pages.product-details', compact('product'));
    }

    public function categoryProducts(){
        dd('categoryProducts');
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Add to Cart
    public function addToCart($slug){
        $productIds = [];
        $product = Product::where('slug', $slug)->firstOrFail();

        // check if the product is simple or configurable

        // check if the product is already added to the cart

        $product_arr = [
            'id' => uniqid(),
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 4,
            'attributes' => [
                'size' => 'L',
                'color' => 'blue'
            ],
            'associatedModel' => $product
        ];

        \Cart::add($product_arr);

        return redirect('/products/'. $slug)->with('message', 'Product '. $product->name .' has been added to cart');
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Cart ###
    public function cart(){
        $items = \Cart::getContent();

        return view('front.pages.cart', compact('items'));
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Checkout & Payment
    public function checkout(){
        if (\Cart::isEmpty()){
            return redirect()->back()->with('message', 'Cart is empty !');
        }

        $items = \Cart::getContent();
        $data['items'] = $items;
        $data['user'] = 'oguzhan';

        return view('front.pages.checkout', compact('data'));
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Profile
    public function profile(){
        return view('front.pages.user-profile');
    }
}
