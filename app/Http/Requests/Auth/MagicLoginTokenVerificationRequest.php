<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MagicLoginTokenVerificationRequest extends FormRequest
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
            'token' => ['required','exists:magic_link_tokens,token'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required'  => "Magic link token wasn't detected, try requesting link again",
            'token.exists'    => 'Link is Invalid, try requesting again!',
        ];
    }
}
