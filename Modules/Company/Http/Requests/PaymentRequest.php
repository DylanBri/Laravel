<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'client_id' => 'bail|required|integer',
        'customer_id' => 'bail|required|integer',
        'customer_name' => 'bail|required|max:255',
        'company_id' => 'bail|required|integer',
        'company_name' => 'bail|required|max:255',
        'monitoring_id' => 'bail|required|integer',
        'monitoring_name' => 'bail|required|max:255',
        'name' => 'bail|required|max:255',
        'payment_request_date' => 'bail|required|date_format:Y-m-d H:i:s',
        'amount_ttc' => 'bail|required|numeric',
        'is_staged' => 'bail|required|boolean',
        'is_done' => 'bail|required|boolean',
        'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
        'payment_method' => 'nullable|max:255',
        'bank_name' => 'nullable|max:255',
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
