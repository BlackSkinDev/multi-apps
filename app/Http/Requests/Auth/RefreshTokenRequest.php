<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RefreshTokenRequest extends FormRequest
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
            'refresh_token' => ['required','exists:refresh_tokens,token']
        ];
    }

    public function messages(): array
    {
        return [
            'refresh_token.exists'    => 'Invalid refresh token was detected! Login again.',
             'refresh_token.required' => 'Session expired! Login again.'
        ];
    }
}
