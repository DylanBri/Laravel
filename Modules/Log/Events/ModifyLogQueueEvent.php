<?php

namespace Modules\Log\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Log\Entities\LogQueue;

class ModifyLogQueueEvent
{
    use SerializesModels;

    /** @var LogQueue $logQueue */
    public $logQueue;
    /** @var string $log */
    public $log;
    /** @var int $state */
    public $state;

    /**
     * Create a new event instance.
     *
     * @param LogQueue $logQueue
     * @param string $log
     * @param int $state
     */
    public function __construct(LogQueue $logQueue, string $log = '', int $state = 0)
    {
        $this->logQueue = $logQueue;
        $this->log = $log;
        $this->state = $state;
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
