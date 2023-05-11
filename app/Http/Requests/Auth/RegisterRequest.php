<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'      =>['required'],
            'email'     =>['required','email','unique:users'],
            'username'  =>['required','unique:users','regex:/^[A-Za-z0-9_]+$/'],
            'password'  =>['required','min:6']
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => 'Username can only contain letters,numbers and underscore'
        ];
    }
}
