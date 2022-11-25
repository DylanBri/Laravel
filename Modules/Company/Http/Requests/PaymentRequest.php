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
        'customer_name' => 'bail|required|string',
        'company_id' => 'bail|required|integer',
        'company_name' => 'bail|required|string',
        'monitoring_id' => 'bail|required|integer',
        'name' => 'bail|required|string',
        'payment_request_date' => 'bail|required|date_format:Y-m-d H:i:s',
        'amount_ttc' => 'bail|required|numeric',
        'is_staged' => 'bail|required|boolean',
        'is_done' => 'bail|required|boolean',
        'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
        'payment_method' => 'nullable|string',
        'bank_name' => 'nullable|string',
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
