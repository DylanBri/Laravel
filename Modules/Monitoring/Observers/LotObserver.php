<?php

namespace Modules\Monitoring\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\Lot;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class LotObserver
{
    /**
     * Handle the Lot "created" event.
     *
     * @param  Lot  $lot
     * @return void
     */
    public function created(Lot $lot)
    {
        if (Auth::user() !== null) {
            //dd(Auth::user());
            //$lot->client_id = session('clientId');
            //$lot->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created Lot',
            'action' => 'create',
            'data' => $lot->toJson(),
            'log' => 'Création du lot ' . $lot->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param  Lot  $lot
     * @return void
     */
    public function deleted(Lot $lot)
    {
        LogQueueRepository::create([
            'name' => 'Deleted Lot',
            'action' => 'delete',
            'data' => $lot->toJson(),
            'log' => 'Suppression du lot ' . $lot->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param  Lot  $lot
     * @return void
     */
    public function restored(Lot $lot)
    {
        //
    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param  Lot  $lot
     * @return void
     */
    public function forceDeleted(Lot $lot)
    {
        //
    }
}
