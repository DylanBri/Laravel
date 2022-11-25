<?php

namespace Modules\Company\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Company\Entities\Payment;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Repositories\LogQueueRepository;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $payment->client_id = session('clientId');
            $payment->saveQuietly();

            $monitoring = $payment->monitoring;
            $query = $monitoring->payments()
                ->selectRaw('SUM(amount_ttc) as sum_amount')
                ->join('monitorings', 'payments.monitoring_id', "=", 'monitorings.id')
                ->whereColumn('payment_date', "<=", 'monitorings.date')
                ->groupBy('monitoring_id')
                ->get();
                //dd($query);
            $monitoring->deduction_previous_payment = $query[0]->sum_amount;
            $monitoring->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Created payment',
            'action' => 'create',
            'data' => $payment->toJson(),
            'log' => 'Création de lentreprise ' . $payment->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        if (Auth::user() !== null) {
            //dd(Auth::user());
        }
        
        LogQueueRepository::create([
            'name' => 'Modified Payment',
            'action' => 'modify',
            'data' => $payment->toJson(),
            'log' => 'Modification de lentreprise ' . $payment->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $monitoring = $payment->monitoring;
            $query = $monitoring->payments()
                ->selectRaw('SUM(amount_ttc) as sum_amount')
                ->join('monitorings', 'payments.monitoring_id', "=", 'monitorings.id')
                ->whereColumn('payment_date', "<=", 'monitorings.date')
                ->groupBy('monitoring_id')
                ->get();
                //dd($query);
            $monitoring->deduction_previous_payment = $query[0]->sum_amount;
            $monitoring->saveQuietly();
        }

        LogQueueRepository::create([
            'name' => 'Deleted Payment',
            'action' => 'delete',
            'data' => $payment->toJson(),
            'log' => 'Suppression de lentreprise ' . $payment->name . ' par l\'utilisateur ' . Auth::id(),
            'state' => LogQueue::STATE_FINISH
        ]);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}