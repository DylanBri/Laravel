<?php

namespace Modules\Monitoring\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\Monitoring;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class MonitoringObserver
{
    /**
     * Handle the Monitoring "created" event.
     *
     * @param  Monitoring  $monitoring
     * @return void
     */
    public function created(Monitoring $monitoring)
    {
        if (Auth::user() !== null) {
            //dd(Auth::user());
            //$monitoring->client_id = session('clientId');
            //$monitoring->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created Monitoring',
            'action' => 'create',
            'data' => $monitoring->toJson(),
            'log' => 'Création du monitoring ' . $monitoring->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Monitoring "updated" event.
     *
     * @param  Monitoring  $monitoring
     * @return void
     */
    public function updated(Monitoring $monitoring)
    {
        LogQueueRepository::create([
            'name' => 'Modified monitoring',
            'action' => 'modify',
            'data' => $monitoring->toJson(),
            'log' => 'Modification du monitoring ' . $monitoring->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Monitoring "updated" event.
     *
     * @param  Monitoring  $monitoring
     * @return void
     */
    public function deleted(Monitoring $monitoring)
    {
        LogQueueRepository::create([
            'name' => 'Deleted Monitoring',
            'action' => 'delete',
            'data' => $monitoring->toJson(),
            'log' => 'Suppression du monitoring ' . $monitoring->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Monitoring "updated" event.
     *
     * @param  Monitoring  $monitoring
     * @return void
     */
    public function restored(Monitoring $monitoring)
    {
        //
    }

    /**
     * Handle the Monitoring "updated" event.
     *
     * @param  Monitoring  $monitoring
     * @return void
     */
    public function forceDeleted(Monitoring $monitoring)
    {
        //
    }
}
