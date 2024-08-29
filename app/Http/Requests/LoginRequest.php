<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'exists:users',
            'password' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'email.exists' => 'This email is not registered',
            'password.required' => 'The password is required to log in',
        ];
    }
}
