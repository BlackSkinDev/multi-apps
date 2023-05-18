<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePictureUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required','file','mimes:png,jpeg,jpg','max:3024']
        ];
    }

    public function messages()
    {
        return [
            'file.file'      => 'Profile picture must be a file',
            'file.mimes'     => 'Only png,jpg and jpeg format are allowed',
            'file.max'       => 'Max size allowed for file is 1mb'
        ];
    }

}
