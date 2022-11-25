<?php

namespace Modules\Monitoring\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkSiteRequest extends FormRequest
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
            'customer_id' => 'bail|required|integer',
            'customer_name' => 'bail|required|max:255',
            'name'=> 'bail|required|max:255',
            'notes'=> 'nullable|max:255',
            'cumul'=> 'nullable|numeric',
            'address1' => 'bail|required|max:255',
            'address2' => 'nullable|max:255',
            'city' => 'bail|required|max:255',
            'zip_code' => 'bail|required|regex:/^\d{5}(?:[-\s]\d{4})?$/',
            'country' => 'nullable|max:50',
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
