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

Route::get('/', 'HomeController@index');
//Route::get('/translate', 'HomeController@translate')->name('translate');

Route::get('/session/profile/logged', 'SessionProfileController@getLogged')->name('sessionProfileGetLogged');
Route::get('/session/reset', 'SessionProfileController@reset');

Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::get('/dashboard', 'HomeController@showDashboard')->name('dashboard');

    Route::get('/client/byId/{id}', 'ClientController@getById')->where('id', '[0-9]+');
    Route::get('/client/list/pageable', 'ClientController@getPaginate');
    Route::resource('client', 'ClientController');

    Route::prefix('user')->group(function () {
        Route::get('/hash/pass', 'HomeController@hashNewPass');

        Route::get('/coordinate/byId/{id}', 'UserCoordinateController@getById')->where('id', '[0-9]+');
        Route::get('/coordinate/form', 'UserCoordinateController@showUserAuth')->name('userCoordinate.show');
        Route::get('/coordinate/autocomplete', 'UserCoordinateController@autocomplete');
        Route::resource('coordinate', 'UserCoordinateController');

        Route::get('/category/list', 'UserCategoryController@getList');
    });
});