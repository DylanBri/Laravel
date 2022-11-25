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

Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::prefix('logQueue')->group(function () {
        Route::get('/list/pageable', 'LogQueueController@getListPaginate')
            ->name('logQueueListPaginate');

        Route::get('/byId/{id}', 'LogQueueController@getById')->name('logQueueGetById')
            ->where('id', '[0-9]+');

        Route::get('/purge', 'LogQueueController@purge');
    });
    Route::resource('logQueue', 'LogQueueController');
});
