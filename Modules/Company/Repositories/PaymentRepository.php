<?php

namespace Modules\Company\Repositories;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Company\Entities\Payment;

class PaymentRepository extends Repository
{
    /**
     * @param array $datas
     * @return Payment
     */
    public static function create(array $datas)
    {
        // Generate Payment
        $datas['client_id'] = session('clientId');
        $payment = new Payment();
        $payment->fill($datas);
        $payment->save();

        
        $monitoring = $payment->monitoring;
        
        $query = Payment::query()
            ->selectRaw('SUM(payments.amount_ttc) as sum_amount')
            ->join('work_site_lot_company', 'monitorings.work_site_lot_company_id', "=", 'work_site_lot_company.id')
            ->where('payment_date', "<", $monitoring->date)
            ->where("payments.is_done", "=", "1")
            ->groupBy('monitorings.work_site_lot_company_id');
        $query1 = $query->get();
        if(!$query1->isEmpty()) {
            $monitoring->payment_amount_ttc = $query1[0]->sum_amount;
            $monitoring->deduction_previous_payment = $query1[0]->sum_amount - $monitoring->deposit;
            $monitoring->saveQuietly();
        }

        return $payment;
    }

    /**
     * @param Payment $payment
     * @param array $datas
     * @return Payment
     */
    public static function update(Payment &$payment, array $datas)
    {
        $payment->update($datas);

        $monitoring = $payment->monitoring;
        $query = Payment::query()
            ->selectRaw('SUM(payments.amount_ttc) as sum_amount')
            ->join('work_site_lot_company', 'monitorings.work_site_lot_company_id', "=", 'work_site_lot_company.id')
            ->where('payment_date', "<", $monitoring->date)
            ->where("payments.is_done", "=", "1")
            ->groupBy('monitorings.work_site_lot_company_id');
        $query1 = $query->get();
        dd($query1);
        if(!$query1->isEmpty()) {
            $monitoring->deduction_previous_payment = $query1[0]->sum_amount - $monitoring->deposit;
            $monitoring->saveQuietly();
        }

        return $payment;
    }

    /**
     * Update the specified resource in storage.
     * @param Payment $payment
     */
    public static function delete(Payment $payment)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $payment->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $monitoring = $payment->monitoring;
        $query = Payment::query()
            ->selectRaw('SUM(payments.amount_ttc) as sum_amount')
            ->join('work_site_lot_company', 'monitorings.work_site_lot_company_id', "=", 'work_site_lot_company.id')
            ->where('payment_date', "<", $monitoring->date)
            ->groupBy('monitorings.work_site_lot_company_id');
        $query1 = $query->get();
        if(!$query1->isEmpty()) {
            $monitoring->deduction_previous_payment = $query1[0]->sum_amount - $monitoring->deposit;
            $monitoring->saveQuietly();
        }
    }

    /**
     * GetById
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Payment
     */
    public static function getById(int $id)
    {
        $payment = Payment::query()
        ->select(['payments.*','companies.name as company_name','customers.name as customer_name','monitorings.name as monitoring_name'])
        ->find($id);

        return $payment;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function getList(array $validatedData) : Collection
    {
        $query = Payment::query()
        ->select(['payments.*','companies.name as company_name','customers.name as customer_name','monitorings.name as monitoring_name']);

        $payments = self::queryFilterAndOrder($query, $validatedData, "payments.id")
            ->get();

        return $payments;
    }

    /**
     * Get Paginate
     *
     * @param integer $currentPage
     * @param integer $perPage
     * @param array $validatedData
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(int $currentPage, int $perPage, array $validatedData)
    {
        $query = Payment::query()
        ->select(['payments.*','companies.name as company_name','customers.name as customer_name','monitorings.name as monitoring_name']);

        $payments = self::queryFilterAndOrder($query, $validatedData, "payments.id")
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return $payments;
    }

    /**
     * @param array $validatedData
     * @return Collection
     */
    public static function search(array $validatedData)
    {
        $query = Payment::query()
        ->select(['payments.*','companies.name as company_name','customers.name as customer_name','monitorings.name as monitoring_name']);

        $payments = self::queryFilterAndOrder($query, $validatedData, "payments.id")->get();

        return $payments;
    }
}
