<?php

namespace Modules\Log\Providers;

use Modules\Log\Events\AddLogQueueEvent;
use Modules\Log\Events\ModifyLogQueueEvent;
use Modules\Log\Listeners\AddLogQueueListener;
use Modules\Log\Listeners\ModifyLogQueueListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AddLogQueueEvent::class => [
            AddLogQueueListener::class
        ],
        ModifyLogQueueEvent::class => [
            ModifyLogQueueListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Observer
    }
}
