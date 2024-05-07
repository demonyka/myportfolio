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
class NewPostRequest extends FormRequest
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
            'files' => 'nullable|array|max:10',
            'files.*' => 'nullable|file|max:10240',
            'post' => 'required|string|min:10|max:16777215',
            'section_id' => 'required|integer'
        ];
    }
}
