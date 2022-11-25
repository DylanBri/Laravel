<?php

namespace Modules\Customer\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Customer\Entities\Customer;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $customer->client_id = session('clientId');
            $customer->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created Customer',
            'action' => 'create',
            'data' => $customer->toJson(),
            'log' => 'Création du client ' . $customer->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        LogQueueRepository::create([
            'name' => 'Modified Customer',
            'action' => 'modify',
            'data' => $customer->toJson(),
            'log' => 'Modification du client ' . $customer->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        LogQueueRepository::create([
            'name' => 'Deleted Customer',
            'action' => 'delete',
            'data' => $customer->toJson(),
            'log' => 'Suppression du client ' . $customer->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        //
    }
}