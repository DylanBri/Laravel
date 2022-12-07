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
    // Monitoring
    Route::prefix('monitoring')->group(function() {
        Route::get('/byId/{id}', 'MonitoringController@getById')->where('id', '[0-9]+');
        Route::get('/list/pageable', 'MonitoringController@getPaginate');
        Route::get('/list', 'MonitoringController@getList');
        Route::get('/list/search', 'MonitoringController@showSearch')->name('monitoring.listing');
        Route::get('/search', 'MonitoringController@search');
        Route::get('/list/work-site-lot-company/{id}', 'MonitoringController@showByWorkSiteLotCompany')->where('id', '[0-9]+');

        // Lot
        Route::prefix('lot')->group(function() {
            Route::get('/byId/{id}', 'LotController@getById')->where('id', '[0-9]+');
            Route::get('/list/pageable', 'LotController@getPaginate');
            Route::get('/list', 'LotController@getList');
            Route::get('/list/search', 'LotController@showSearch')->name('lot.listing');
            Route::get('/search', 'LotController@search');
        });
        Route::resource('lot', 'LotController');

         //workSiteLotCompany
        Route::prefix('work-site-lot-company')->group(function() {
            Route::get('/byId/{id}', 'WorkSiteLotCompanyController@getById')->where('id', '[0-9]+');
            Route::get('/list/pageable', 'WorkSiteLotCompanyController@getPaginate');
            Route::get('/list', 'WorkSiteLotCompanyController@getList');
            Route::get('/list/search', 'WorkSiteLotCompanyController@showSearch')->name('work-site-lot-company.listing');
            Route::get('/search', 'WorkSiteLotCompanyController@search');
            Route::get('/list/work-site/{id}', 'WorkSiteLotCompanyController@showByWorkSite')->where('id', '[0-9]+');
            Route::get('/list/monitoring/{id}', 'WorkSiteLotCompanyController@showByMonitoring')->where('id', '[0-9]+');
            Route::get('/list/type/{id}', 'WorkSiteLotCompanyController@showByType')->where('id', '[0-9]+');
            Route::get('/list/monitoring/{monitoringId}/type/{typeId}', 'WorkSiteLotCompanyController@showByMonitoringAndType')
                ->where('monitoringId', '[0-9]+')->where('typeId', '[0-9]+');
            Route::get('/{id}/payment', 'WorkSiteLotCompanyController@getPayments')->where('id', '[0-9]+');
        });
        Route::resource('work-site-lot-company', 'WorkSiteLotCompanyController'); 
        
        // workSite
        Route::prefix('work-site')->group(function() {
            Route::get('/byId/{id}', 'WorkSiteController@getById')->where('id', '[0-9]+');
            Route::get('/list/pageable', 'WorkSiteController@getPaginate');
            Route::get('/list', 'workSiteController@getList');
            Route::get('/list/search', 'WorkSiteController@showSearch')->name('work-site.listing');
            Route::get('/search', 'WorkSiteController@search');
            Route::get('/list/customer/{id}', 'WorkSiteController@showByCustomer')->where('id', '[0-9]+');
        });

        Route::resource('work-site', 'WorkSiteController');
    });
    Route::resource('monitoring', 'MonitoringController');
});