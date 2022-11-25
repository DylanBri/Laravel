<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\User;
use App\Models\UserCoordinate;
use App\Policies\ClientPolicy;
use App\Policies\UserCoordinatePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Client::class => ClientPolicy::class,
        User::class => UserPolicy::class,
        UserCoordinate::class => UserCoordinatePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
