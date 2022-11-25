<?php

namespace App\Http\Requests;

use App\Models\UserCoordinate;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $coordinate = UserCoordinateRepository::getByUserId($this->user()->id);
        return $coordinate->isSuperAdministrator();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|max:255',
            'folder' => 'nullable|max:255',
            'address' => 'bail|required|max:255',
            'address2' => 'nullable|max:255',
            'zip_code' => 'nullable|regex:/^\d{5}(?:[-\s]\d{4})?$/',
            'city' => 'bail|required|max:255',
            'country' => 'bail|required|max:50',
//            'country' => 'bail|required|exists:countries',
            'email' => 'bail|required|email',
            'phone' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
            'licence' => 'bail|required|max:50',
            'licence_expired_at' => 'bail|required|date_format:Y-m-d H:i:s',
            'socket_host' => 'nullable|max:255',
            'socket_port' => 'nullable|max:255',
            'enabled' => 'bail|required|boolean',
        ];
    }
}
