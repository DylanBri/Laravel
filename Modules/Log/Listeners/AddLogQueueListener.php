<?php

namespace Modules\Log\Listeners;

//use Illuminate\Support\Facades\Log;
use Modules\Log\Events\AddLogQueueEvent;

class AddLogQueueListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AddLogQueueEvent  $event
     * @return void
     */
    public function handle(AddLogQueueEvent $event)
    {
        $event->logQueue->fill([
            'name' => $event->name,
            'action' => $event->action,
            'data' => $event->data,
        ])->save();
    }
}
