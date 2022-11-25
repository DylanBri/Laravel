<?php

namespace Modules\Log\Events;

use Illuminate\Queue\SerializesModels;
//use Illuminate\Support\Facades\Log;
use Modules\Log\Entities\LogQueue;

class AddLogQueueEvent
{
    use SerializesModels;

    /** @var LogQueue $logQueue */
    public $logQueue;
    /** @var string $name */
    public $name;
    /** @var string $action */
    public $action;
    /** @var string $data */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param LogQueue $logQueue
     * @param string $name
     * @param string $action
     * @param string $data
     */
    public function __construct(LogQueue $logQueue, string $name, string $action = '', string $data = '')
    {
        $this->logQueue = $logQueue;
        $this->name = $name;
        $this->action = $action;
        $this->data = $data;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
