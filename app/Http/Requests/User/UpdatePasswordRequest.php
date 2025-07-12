<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'min:8',
                'max:255'
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
        ];
    }
}
