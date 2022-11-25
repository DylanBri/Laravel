<?php

namespace Modules\Monitoring\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\WorkSite;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class WorkSiteObserver
{
    /**
     * Handle the WorkSite "created" event.
     *
     * @param  WorkSite  $workSite
     * @return void
     */
    public function created(WorkSite $worksite)
    {
        if (Auth::user() !== null) {
            //dd(Auth::user());
            //$workSite->client_id = session('clientId');
            //$workSite->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created work site',
            'action' => 'create',
            'data' => $worksite->toJson(),
            'log' => 'Création du work site ' . $workSite->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the WorkSite "updated" event.
     *
     * @param  WorkSite  $worksite
     * @return void
     */
    public function updated(WorkSite $worksite)
    {
        LogQueueRepository::create([
            'name' => 'Modified WorkSite',
            'action' => 'modify',
            'data' => $worksite->toJson(),
            'log' => 'Modification du work site ' . $worksite->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the WorkSite "updated" event.
     *
     * @param  WorkSite  $worksite
     * @return void
     */
    public function deleted(WorkSite $worksite)
    {
        LogQueueRepository::create([
            'name' => 'Deleted WorkSite',
            'action' => 'delete',
            'data' => $worksite->toJson(),
            'log' => 'Suppression du work site ' . $worksite->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the WorkSite "updated" event.
     *
     * @param  WorkSite  $worksite
     * @return void
     */
    public function restored(WorkSite $worksite)
    {
        //
    }

    /**
     * Handle the WorkSite "updated" event.
     *
     * @param  WorkSite  $worksite
     * @return void
     */
    public function forceDeleted(WorkSite $worksite)
    {
        //
    }
}
