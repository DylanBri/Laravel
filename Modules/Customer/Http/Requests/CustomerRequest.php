<?php

namespace Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'bail|required|max:255',
            'gender' => 'nullable|max:255',
            'phone' => 'nullable|max:50',
            'fax' => 'nullable|max:50',

            'address_1' => 'bail|required|max:255',
            'address_2' => 'nullable|max:255',
            'zip_code' => 'bail|required|max:10',
            'city' => 'bail|required|max:50',
            'country' => 'nullable|max:50',
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
