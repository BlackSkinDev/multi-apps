<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'token'                 => ['required','exists:password_reset_tokens,token'],
            'new_password'          => ['required','min:6'],
            'confirm_new_password'  => ['required','min:6','same:new_password']
        ];
    }

    public function messages(): array
    {
        return [
            'token.required'                 => "Password reset token wasn't detected, try requesting link again!",
            'token.exists'                   => 'Invalid password reset link, try requesting link again!',
            'new_password.required'          => 'New password is required',
            'confirm_new_password.required'  => 'Confirm new password',
            'confirm_new_password.same'      => 'Passwords do not match',
        ];
    }
}
