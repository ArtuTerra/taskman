<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'bail|required|string|max:255',
            'description' => 'string|max:500|nullable',
            'completed' => 'boolean|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required to create task',
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
