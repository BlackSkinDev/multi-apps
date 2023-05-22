<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
            'old_password'  => ['required'],
            'new_password'  => ['required','min:6', 'different:old_password',]
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required'     => 'Old password is required',
            'new_password.required'     => 'Enter new password',
            'new_password.different'    => 'Enter a different password from your old password',
        ];
    }
}
