<?php

namespace Modules\Customer\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Customer\Entities\Address;
use Modules\Customer\Entities\Customer;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class AddressObserver
{
    /**
     * Handle the Address "created" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function created(Address $address)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
//            $address->client_id = session('clientId');
//            $address->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created Address',
            'action' => 'create',
            'data' => $address->toJson(),
            'log' => 'Création de l\'address ' . $address->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Address "updated" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function updated(Address $address)
    {
        LogQueueRepository::create([
            'name' => 'Modified Address',
            'action' => 'modify',
            'data' => $address->toJson(),
            'log' => 'Modification de l\'address ' . $address->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Address "updated" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function deleted(Address $address)
    {
        LogQueueRepository::create([
            'name' => 'Deleted Address',
            'action' => 'delete',
            'data' => $address->toJson(),
            'log' => 'Suppression de l\'address ' . $address->id . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Address "updated" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function restored(Address $address)
    {
        //
    }

    /**
     * Handle the Address "updated" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function forceDeleted(Address $address)
    {
        //
    }
}