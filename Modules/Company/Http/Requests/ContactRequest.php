<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'company_id' => 'bail|required|integer',
            'company_name' => 'bail|required|string',
            'firstname' => 'bail|required|max:255', 
            'lastname'=> 'bail|required|max:255',
            'phone'=> 'nullable|max:50',
            'email'=> 'nullable|email',
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
