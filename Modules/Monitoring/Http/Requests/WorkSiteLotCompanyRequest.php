<?php

namespace Modules\Monitoring\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkSiteLotCompanyRequest extends FormRequest
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
            'id' => 'nullable|integer',
            'work_site_id' => 'bail|required|integer',
            'work_site_name' => 'bail|required|max:255',
            'lot_id' => 'bail|required|integer',
            'lot_name' => 'bail|required|max:255',
            'company_id' => 'bail|required|integer',
            'company_name' => 'bail|required|max:255',
            'monitoring_id' => 'nullable|integer',
            //'customer_id' => 'nullable|integer',
            'name' => 'bail|required|max:255',
            'is_type' => 'nullable|max:255',
            'amount_ttc' => 'bail|required|numeric',
            'cumul_monitoring' => 'nullable|numeric',
            'cumul_payment' => 'nullable|numeric',
            'enabled' => 'bail|required|boolean',
            'suppressed' => 'bail|required|boolean'
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
