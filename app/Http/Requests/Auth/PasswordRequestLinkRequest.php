<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequestLinkRequest extends FormRequest
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
            'email' => ['required','exists:users']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'  => 'Email is required to send link',
            'email.exists'    => 'This email is not associated with any user'
        ];
    }
}
