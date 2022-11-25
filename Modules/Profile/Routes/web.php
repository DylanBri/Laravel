<?php

use \Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('supadm')->middleware('supadm')->group(function () {
        Route::get('/dashboard', 'SuperAdministratorController@showDashboard')->name('supadm.dashboard');
        Route::get('/byId/{id}', 'SuperAdministratorController@getById')->where('id', '[0-9]+');
        Route::get('/list/pageable', 'SuperAdministratorController@getPaginate');
    });
    Route::resource('supadm', 'SuperAdministratorController');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', 'AdministratorController@showDashboard')->name('admin.dashboard');
        Route::get('/byId/{id}', 'AdministratorController@getById')->where('id', '[0-9]+');
        Route::get('/list/pageable', 'AdministratorController@getPaginate');
    });
    Route::resource('admin', 'AdministratorController');

    Route::prefix('manager')->group(function () {
        Route::get('/dashboard', 'ManagerController@showDashboard')->name('manager.dashboard');
        Route::get('/byId/{id}', 'ManagerController@getById')->where('id', '[0-9]+');
        Route::get('/list/pageable', 'ManagerController@getPaginate');
    });
    Route::resource('manager', 'ManagerController');

    Route::prefix('user')->group(function () {
        Route::get('/dashboard', 'UserController@showDashboard')->name('user.dashboard');
        Route::get('/byId/{id}', 'UserController@getById')->where('id', '[0-9]+');
        Route::get('/list/pageable', 'UserController@getPaginate');
        Route::get('/list/search', 'UserController@showSearch')->name('user.listing');
        Route::get('/search', 'UserController@search');
    });
    Route::resource('user', 'UserController');
});
