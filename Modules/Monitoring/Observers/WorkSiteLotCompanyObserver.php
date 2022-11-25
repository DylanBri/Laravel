<?php

namespace Modules\Monitoring\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\WorkSiteLotCompany;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class WorkSiteLotCompanyObserver
{
    /**
     * Handle the Lot "created" event.
     *
     * @param  WorkSiteLotCompany  $workSiteLotCompany
     * @return void
     */
    public function created(WorkSiteLotCompany $workSiteLotCompany)
    {
        if (Auth::user() !== null) {
            //dd(Auth::user());
            //$lot->client_id = session('clientId');
            //$lot->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created',
            'action' => 'create',
            'data' => $workSiteLotCompany->toJson(),
            'log' => 'Création du lot ' . $workSiteLotCompany->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param  WorkSiteLotCompany  $workSiteLotCompany
     * @return void
     */
    public function deleted(WorkSiteLotCompany $workSiteLotCompany)
    {
        LogQueueRepository::create([
            'name' => 'Deleted Lot',
            'action' => 'delete',
            'data' => $workSiteLotCompany->toJson(),
            'log' => 'Suppression du lot ' . $workSiteLotCompany->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param  WorkSiteLotCompany  $workSiteLotCompany
     * @return void
     */
    public function restored(WorkSiteLotCompany $workSiteLotCompany)
    {
        //
    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param  WorkSiteLotCompany  $workSiteLotCompany
     * @return void
     */
    public function forceDeleted(WorkSiteLotCompany $workSiteLotCompany)
    {
        //
    }
}
