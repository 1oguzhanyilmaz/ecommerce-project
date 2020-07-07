<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth']],function () {
    Route::get('dashboard', 'DashboardController@index');
    Route::resource('categories', 'CategoryController');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
