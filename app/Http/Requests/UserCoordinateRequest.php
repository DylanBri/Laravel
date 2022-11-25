<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCoordinateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'bail|required|numeric',
            'category_id' => 'bail|required|numeric',
            'quality' => 'nullable|max:50',
            'address' => 'bail|required|max:255',
            'address2' => 'nullable|max:255',
            'zip_code' => 'nullable|regex:/^\d{5}(?:[-\s]\d{4})?$/',
            'city' => 'nullable|max:255',
            'region' => 'nullable|max:50',
            'country' => 'nullable|max:50',
//            'country' => 'bail|required|exists:countries',
            'phone' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
            'mobile' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
            'enabled' => 'bail|required|boolean',
            'suppressed' => 'bail|required|boolean',
        ];
    }
}
