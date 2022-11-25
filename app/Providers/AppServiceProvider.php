<?php

namespace App\Providers;

use App\Models\UserCoordinate;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Support\Facades\Blade;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('supadm', function () {
            if (!auth()->check()) {
                return;
            }

            /** @var UserCoordinate $coordinate */
            $coordinate = UserCoordinateRepository::getByUserId(auth()->user()->getAuthIdentifier());

            if (!$coordinate instanceOf UserCoordinate) {
                return;
            }

            return $coordinate->isSuperAdministrator();
        });

        Blade::if('admin', function () {
            if (!auth()->check()) {
                return;
            }

            /** @var UserCoordinate $coordinate */
            $coordinate = UserCoordinateRepository::getById(auth()->user()->getAuthIdentifier());

            if (!$coordinate instanceOf UserCoordinate) {
                return;
            }

            return $coordinate->isAdministrator();
        });

        Blade::if('manager', function () {
            if (!auth()->check()) {
                return;
            }

            /** @var UserCoordinate $coordinate */
            $coordinate = UserCoordinateRepository::getById(auth()->user()->getAuthIdentifier());

            if (!$coordinate instanceOf UserCoordinate) {
                return;
            }

            return $coordinate->isManager();
        });

        Blade::if('user', function () {
            if (!auth()->check()) {
                return;
            }

            /** @var UserCoordinate $coordinate */
            $coordinate = UserCoordinateRepository::getById(auth()->user()->getAuthIdentifier());

            if (!$coordinate instanceOf UserCoordinate) {
                return;
            }

            return $coordinate->isUser();
        });

//        Blade::if('viewer', function () {
//            if (!auth()->check()) {
//                return;
//            }

//            /** @var UserCoordinate $coordinate */
//            $coordinate = UserCoordinateRepository::getById(auth()->user()->getAuthIdentifier());

//            if (!$coordinate instanceOf UserCoordinate) {
//                return;
//            }

//            return $coordinate->isViewer();
//        });
    }
}
