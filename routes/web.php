<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'],function () {
    Route::redirect('/', '/admin/dashboard');
    Route::match(['get','post'],'login', 'LoginController@login')->name('admin.login');

    Route::group(['middleware' => 'admin-auth'],function () {
        Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
        Route::resource('categories', 'CategoryController');

        Route::post('logout', 'LoginController@logout')->name('admin.logout');
        Route::resource('products', 'ProductController');
        Route::get('products/{productID}/images', 'ProductController@images')->name('products.images');
        Route::get('products/{productID}/add-image', 'ProductController@add_image')->name('products.add_image');
        Route::post('products/images/{productID}', 'ProductController@upload_image')->name('products.upload_image');
        Route::delete('products/images/{imageID}', 'ProductController@remove_image')->name('products.remove_image');

        Route::resource('attributes', 'AttributeController');
        Route::get('attributes/{attributeID}/options', 'AttributeController@options')->name('attributes.options');
        Route::get('attributes/{attributeID}/add-option', 'AttributeController@add_option')->name('attributes.add_option');
        Route::post('attributes/options/{attributeID}', 'AttributeController@store_option')->name('attributes.store_option');
        Route::get('attributes/options/{optionID}/edit', 'AttributeController@edit_option')->name('attributes.edit_option');
        Route::put('attributes/options/{optionID}', 'AttributeController@update_option')->name('attributes.update_option');
        Route::delete('attributes/options/{optionID}', 'AttributeController@remove_option')->name('attributes.remove_option');

        Route::resource('roles', 'RoleController');
        Route::resource('users', 'UserController');
    });
});

Auth::routes();

// Front Side
Route::get('/', 'HomeController@home')->name('home');

// Products
Route::get('/products', 'HomeController@products')->name('products');
Route::get('/products/{slug}', 'HomeController@productDetails')->name('product.details');
Route::get('/products/category/{slug}', 'HomeController@categoryProducts')->name('category.products');

Route::post('/product/add/cart', 'HomeController@addToCart')->name('product.add.cart');

Route::get('/cart', 'HomeController@cart')->name('cart');
Route::get('/cart/item/{itemId}/remove', 'HomeController@removeItem')->name('cart.remove');
Route::get('/cart/clear', 'HomeController@clearCart')->name('cart.clear');
Route::post('/cart/item/update', 'HomeController@updateCart')->name('update.cart');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::get('/orders/checkout', 'HomeController@checkout')->name('orders.checkout');
    Route::post('/orders/set-shipping', 'HomeController@setShipping')->name('orders.set.shipping');
    Route::post('/orders/checkout', 'HomeController@placeOrder')->name('orders.checkout.place.order');
    Route::get('/orders/received/{orderID}', 'HomeController@received')->name('orders.received');
    Route::get('/orders', 'HomeController@orders')->name('orders');
    Route::get('/orders/{orderID}', 'HomeController@orderShow')->name('order.show');
});
