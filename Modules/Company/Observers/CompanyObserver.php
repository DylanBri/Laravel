<?php

namespace Modules\Company\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Company\Entities\Company;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function created(Company $company)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $company->client_id = session('clientId');
            $company->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created company',
            'action' => 'create',
            'data' => $company->toJson(),
            'log' => 'Création de lentreprise ' . $company->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function updated(Company $company)
    {
        LogQueueRepository::create([
            'name' => 'Modified Company',
            'action' => 'modify',
            'data' => $company->toJson(),
            'log' => 'Modification de lentreprise ' . $company->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        LogQueueRepository::create([
            'name' => 'Deleted Company',
            'action' => 'delete',
            'data' => $company->toJson(),
            'log' => 'Suppression de lentreprise ' . $company->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  Company  $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}