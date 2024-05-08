<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Rule;
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => ['nullable','string'],
            'username'  => ['required','unique:users','regex:/^[a-z0-9_]+$/','min:6'],
            'email'     => ['required','email','unique:users'],
            'password' => ['required', 'min:8', 'max:16', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'The email address is already associated with another account.',
            'username.unique' => 'The username is already associated with another account.',
            'username.regex' => 'The username can only contain letters, numbers, and underscores.',
            'password.regex' => 'The password must contain an uppercase, lowercase letter and a special character.',
        ];
    }
}
