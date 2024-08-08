<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'description' => 'string|max:500',
            'completed' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'You have reached maximum ammount of characters in title',
            'description.max' => 'You have reached maximum ammount of characters in description'
        ];

    }

    public function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
