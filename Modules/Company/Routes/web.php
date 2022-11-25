<?php

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
    Route::prefix('company')->group(function() {
        Route::get('/byId/{id}', 'CompanyController@getById')->where('id', '[0-9]+');
        Route::get('/list/pageable', 'CompanyController@getPaginate');
        Route::get('/list', 'CompanyController@getList');
        Route::get('/list/search', 'CompanyController@showSearch')->name('company.listing');
        Route::get('/search', 'CompanyController@search');

        // Payment
        Route::prefix('payment')->group(function() {
            Route::get('/byId/{id}', 'PaymentController@getById')->where('id', '[0-9]+');
            Route::get('/list/pageable', 'PaymentController@getPaginate');
            Route::get('/list', 'PaymentController@getList');
            Route::get('/list/search', 'PaymentController@showSearch')->name('Payment.listing');
            Route::get('/search', 'PaymentController@search');
        });
        Route::resource('payment', 'PaymentController');
    });
    Route::resource('company', 'CompanyController');
});