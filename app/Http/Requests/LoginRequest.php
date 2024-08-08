<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class LoginRequest extends FormRequest
{

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
            'email.exists:users' => 'The email given is not registered',
            'password.required' => 'The password is required to log in',
        ];

    }
}
