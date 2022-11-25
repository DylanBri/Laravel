<?php

namespace Modules\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'quality' => 'nullable|max:50',
            'name' => 'bail|required|max:255',
            'email' => 'bail|required|email',
            'password' => 'nullable|max:255',
            'address' => 'bail|required|max:255',
            'address2' => 'nullable|max:255',
            'zip_code' => 'nullable|regex:/^\d{5}(?:[-\s]\d{4})?$/',
            'city' => 'nullable|max:255',
            'region' => 'nullable|max:255',
            'country' => 'bail|required|max:50',
//            'country' => 'bail|required|exists:countries',
            'phone' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
            'mobile' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
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
