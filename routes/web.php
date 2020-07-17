<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth']],function () {
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::resource('categories', 'CategoryController');

    Route::match(['get','post'],'login', 'LoginController@login')->name('admin.login');
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

Auth::routes();

// Front Side
Route::get('/', 'HomeController@products')->name('home');

// Products
Route::get('/products', 'HomeController@products')->name('products');
Route::get('/products/{slug}', 'HomeController@productDetails')->name('product.details');
Route::get('/category/{slug}', 'HomeController@categoryProducts')->name('category.products');

Route::get('/product/add/cart/{slug}', 'HomeController@addToCart')->name('product.add.cart');

Route::get('/cart', 'HomeController@cart')->name('cart');
Route::get('/cart/item/{itemId}/remove', 'HomeController@removeItem')->name('cart.remove');
Route::get('/cart/clear', 'HomeController@clearCart')->name('cart.clear');
Route::post('/cart/update', 'HomeController@updateCart')->name('update.cart');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::get('/checkout', 'HomeController@checkout')->name('checkout.index');
    Route::post('/checkout/order', 'HomeController@placeOrder')->name('checkout.place.order');
    Route::get('/checkout/payment/complete', 'HomeController@complete')->name('checkout.payment.complete');
});

// Cart
//Route::get('/cart', 'CartController@getCart')->name('cart');
//Route::get('/cart/item/{itemId}/remove', 'CartController@removeItem')->name('cart.remove');
//Route::get('/cart/clear', 'CartController@clearCart')->name('cart.clear');
//Route::post('/cart', 'CartController@store');
//Route::post('/cart/update', 'CartController@update');
