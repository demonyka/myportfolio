<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string email
 * @property string password
 * @property string password_confirmation
 */
class RegisterRequest extends FormRequest
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
            'fullname' => 'required|string|max:128|min:6',
            'email' => 'required|string|lowercase|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8|max:64',
        ];
    }
}
