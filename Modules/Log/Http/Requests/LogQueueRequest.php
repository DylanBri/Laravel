<?php

namespace Modules\Log\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogQueueRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|max:50',
            'action' => 'bail|required|max:50',
            'data' => 'nullable|string',
            'log' => 'bail|required|string',
            'state' => 'bail|required|integer',
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
