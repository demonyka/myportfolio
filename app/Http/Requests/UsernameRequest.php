<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsernameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Можно изменить на нужную логику авторизации пользователя
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|regex:/^[a-zA-Z0-9]{3,16}$/',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'username_required',
            'username.regex' => 'username_regex',
        ];
    }
}
