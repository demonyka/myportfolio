<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $reservedWords = [
            'profile',
            'storage',
            'admin',
            'login',
            'register',
            'myportfolio',
            'resume',
            'event',
            'portfolio',
            'about',
            'privacy',
            'video',
            'moderation',
            'moder',
            'phpmyadmin',
            'welcome',
            'index'
        ];

        return [
            'fullname' => 'required|string|min:6|max:128',
            'username' => [
                'nullable',
                'string',
                'min:5',
                'max:24',
                'regex:/^(?!id\d+$)[a-zA-Z0-9]{3,16}$/',
                Rule::unique('users')->ignore($this->user()->id)->where(function ($query) {
                    return $query->whereNotNull('username');
                }),
                Rule::notIn($reservedWords),
            ],
            'birthday' => 'nullable|date|date_format:Y-m-d',
            'geolocation' => 'nullable|string|min:6|max:128',
            'job' => 'nullable|string|max:128|min:6',
            'links' => 'nullable|array|max:3',
            'links.*' => 'nullable|string|url:http,https|min:6|max:128'
        ];
    }
}
