<?php

namespace Modules\Log\Listeners;

use Modules\Log\Events\ModifyLogQueueEvent;

class ModifyLogQueueListener
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
     * @param  ModifyLogQueueEvent  $event
     * @return void
     */
    public function handle(ModifyLogQueueEvent $event)
    {
        $event->logQueue->fill([
            'log' => $event->log,
            'state' => $event->state,
        ])->save();
    }
}
