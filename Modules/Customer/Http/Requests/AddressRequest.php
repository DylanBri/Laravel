<?php

namespace Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'address1' => 'bail|required|max:255',
            'address2' => 'nullable|max:255',
            'zip_code' => 'bail|required|regex:/^\d{5}(?:[-\s]\d{4})?$/',
            'city' => 'bail|required|max:50',
            'country' => 'nullable|max:50'
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
