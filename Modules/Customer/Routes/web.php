<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::prefix('customer')->group(function() {
        Route::get('/byId/{id}', 'CustomerController@getById')->where('id', '[0-9]+');
        Route::get('/list/pageable', 'CustomerController@getPaginate');
        Route::get('/list', 'CustomerController@getList');
        Route::get('/list/search', 'CustomerController@showSearch')->name('customer.listing');
        Route::get('/search', 'CustomerController@search');

        // Address
        Route::prefix('address')->group(function() {
            Route::get('/byId/{id}', 'AddressController@getById')->where('id', '[0-9]+');
            Route::get('/list/pageable', 'AddressController@getPaginate');
//            Route::get('/list', 'AddressController@getList');
            Route::get('/list/search', 'AddressController@showSearch')->name('address.listing');
            Route::get('/search', 'AddressController@search');
        });

        Route::resource('address', 'AddressController');
    });

    Route::resource('customer', 'CustomerController');
});
