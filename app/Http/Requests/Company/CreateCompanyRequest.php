<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required','unique:companies'],
            'description'   => ['required'],
            'logo'          => ['required','file','mimes:png,jpeg,jpg','max:1024']
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'Name entered is already associated with a company',
            'logo.file'      => 'Logo must be a file',
            'logo.mimes'     => 'Only png,jpg and jpeg format are allowed',
            'logo.max'       => 'Max size allowed for logo is 1mb'
        ];
    }

}
