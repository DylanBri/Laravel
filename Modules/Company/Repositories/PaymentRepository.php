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

        // Suomme des paiements par lot non effectué avant la demande 
        $query = Payment::query()
                ->selectRaw('SUM(payments.amount_ttc) as sum_amount')
                    ->join('work_site_lot_company', 'monitorings.work_site_lot_company_id', '=', 'work_site_lot_company.id')
                    ->where('payments.is_done', '=', '0')
                    ->where('work_site_lot_company.id', '=', $payment->monitoring->work_site_lot_company_id)
                    ->where('payments.payment_date', '<', $payment->payment_request_date)
                    ->groupBy('monitorings.work_site_lot_company_id');
        dd($query->get());

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