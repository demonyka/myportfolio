<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed avatar
 * @property mixed fullname
 * @property mixed username
 * @property mixed birthday
 * @property mixed geolocation
 * @property mixed job
 * @property array links
 */
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
            'public',
            'login',
            'register',
            'myportfolio',
            'resume',
            'event',
            'portfolio',
            'about',
            'about-us',
            'terms',
            'privacy',
            'video',
            'moderation',
            'moder',
            'phpmyadmin',
            'welcome',
            'index'
        ];

        return [
            'avatar' => 'nullable|file|max:10240|mimes:jpeg,png',
            'fullname' => 'required|string|min:6|max:128',
            'username' => [
                'nullable',
                'string',
                'min:5',
                'max:24',
                'regex:/^(?!id\d+$)(?=.*[a-zA-Z])[a-zA-Z0-9]{3,16}$/',
                Rule::unique('users')->ignore($this->user()->id)->where(function ($query) {
                    return $query->whereNotNull('username');
                }),
                Rule::notIn($reservedWords),
            ],
            'links' => 'nullable|array|max:3',
            'links.*' => 'nullable|string|url:http,https|min:6|max:128',
            'birthday' => 'nullable|date|date_format:Y-m-d',

            'phone' => 'nullable|string|min:6|max:24',

            'citizen' => 'nullable|string|min:6|max:128',
            'city' => 'nullable|string|min:6|max:128',

            'jobs' => 'nullable|array|max:10',
            'jobs.name' => 'nullable|string|max:128|min:6',
            'jobs.jobtitle' => 'nullable|string|max:128|min:6',
            'jobs.start_at' => 'nullable|date|date_format:Y-m-d',
            'jobs.end_at' => 'nullable|date|date_format:Y-m-d',

            'education' => 'nullable|array|max:10',
            'education.name' => 'nullable|string|max:128|min:6',
            'education.degree' => 'nullable|string|max:128|min:6',
            'education.start_at' => 'nullable|date|date_format:Y-m-d',
            'education.end_at' => 'nullable|date|date_format:Y-m-d',
        ];
    }
}
