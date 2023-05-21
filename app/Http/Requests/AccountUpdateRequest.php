<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
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
            'name'      => ['required'],
            'username'  => ['required','regex:/^[a-z0-9_]+$/','min:6',Rule::unique('users')->ignore(auth()->user()->id)],
            'bio'       => ['nullable','max:225'],
            'linkedin'  => ['nullable','url'],
            'phone'     => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'Username can only contain letters,numbers and underscore'
        ];
    }
}
