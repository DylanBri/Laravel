<?php

namespace Modules\Monitoring\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonitoringRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            ///lot_id' => 'bail|required|integer',
            //'work_site_id' => 'bail|required|integer',
            'work_site_lot_company_id' => 'bail|required|integer',
            'work_site_lot_company_name' => 'bail|required|max:255',
            'name'=> 'bail|required|max:255',
            'date'=> 'bail|required|date_format:Y-m-d H:i:s',
            'total_modify_market_amount'=> 'nullable|numeric',
            'total_market_amount'=> 'nullable|numeric',
            'market_amount'=> 'nullable|numeric',
            'modify_market_amount'=> 'nullable|numeric',
            'tot_market_amount'=> 'nullable|numeric',
            'rate_vat'=> 'nullable|numeric',
            'deposit'=> 'nullable|numeric',
            'account_percent'=> 'nullable|numeric',
            'account_management_percent'=> 'nullable|numeric',
            'bank_guarantee'=> 'nullable|numeric',
            'retention_money_percent'=> 'nullable|numeric',
            'retention_money'=> 'nullable|numeric',
            'balance'=> 'nullable|numeric',
            'doc_penality_percent'=> 'nullable|numeric',
            'doc_penality'=> 'nullable|numeric',
            'work_penality'=> 'nullable|numeric',
            'payment_amount_ttc'=> 'nullable|numeric',
            'deduction_previous_payment'=> 'nullable|numeric',
            'amount_to_pay'=> 'nullable|numeric',
            'cumul_work_sit_lot_company'=> 'nullable|numeric',
            'cumul_monitoring_previous'=> 'nullable|numeric',
            'progress'=> 'nullable|numeric',
            'balance_du'=> 'nullable|numeric',
            'deduction_previous_payment' =>'nullable|numeric',
            'enabled' => 'bail|required|boolean',
            'suppressed' => 'bail|required|boolean',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
