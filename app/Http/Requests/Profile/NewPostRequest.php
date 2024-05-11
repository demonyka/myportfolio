<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed text
 * @property array files
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
            'title' => 'required|string|min:2|max:128',
            'text' => 'required|string|min:2|max:8192',
            'links' => 'nullable|array|max:3',
            'links.*' => 'nullable|string|url:http,https|min:6|max:128'
        ];
    }
}
