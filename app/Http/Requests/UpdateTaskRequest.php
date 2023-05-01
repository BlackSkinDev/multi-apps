<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
        $taskId = $this->route('task')->id;
        return [
            'title'       => ['required', Rule::unique('tasks')->ignore($taskId)],
            'description' => ['nullable','string'],
            'user_id'     => ['nullable','exists:users,id'],
        ];
    }
}
