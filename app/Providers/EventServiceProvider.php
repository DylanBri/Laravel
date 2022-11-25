<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\SessionProfile;
use App\Models\UserCoordinate;
use App\Observers\ClientObserver;
use App\Observers\SessionProfileObserver;
use App\Observers\UserCoordinateObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        SessionProfile::observe(SessionProfileObserver::class);
        Client::observe(ClientObserver::class);
        UserCoordinate::observe(UserCoordinateObserver::class);
    }
}
