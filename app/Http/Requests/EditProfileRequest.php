<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'fullname' => 'required|string|min:3|max:128',
            'username' => 'nullable|string|min:5|max:24|regex:/^[a-zA-Z0-9]{3,16}$/',
            'birthday' => 'nullable|date|date_format:Y-m-d',
            'geolocation' => 'nullable|string|max:128',
            'job' => 'nullable|string|max:128',
            'links' => 'nullable|array|max:3',
            'links.*' => 'nullable|string|max:128|'
        ];
    }
}
