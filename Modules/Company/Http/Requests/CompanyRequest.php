<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'title' => 'nullable|max:255', 
            'name'=> 'bail|required|max:255',
            'address_1'=> 'bail|required|max:255',
            'address_2'=> 'nullable|max:255',
            'zip_code'=> 'bail|required|regex:/^\d{5}(?:[-\s]\d{4})?$/',
            'city'=> 'bail|required|max:50',
            'country'=> 'nullable|max:255',
            'phone'=> 'bail|required|max:50',
            'supervisor'=> 'nullable|max:255',
            'siret'=> 'bail|required|max:14',
            'classification'=> 'bail|required|max:255',
            'code_ape'=> 'bail|required|max:5',
            'email'=> 'nullable|email',
            'insurance'=> 'nullable|max:255',
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
