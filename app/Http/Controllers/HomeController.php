<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderItem;
use App\Product;
use App\ProductInventory;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct(){
        parent::__construct();
    }

    public function home(){
        $products = Product::all();

        return view('front.pages.home', compact('products'));
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Profile
    public function profile(Request $request){

        if ($request->isMethod('post')){
            auth()->user()->userDetail->update($request->all());

            \Session::flash('success', 'The information has been successfully updated.');
            return redirect()->back();
        }

        $user = auth()->user();

        $breadcrumbs = [
            'notNecessary' => 'profile',
        ];

        return view('front.pages.user-profile', compact('user','breadcrumbs'));
    }

}
