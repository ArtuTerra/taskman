<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'bail|required|string|max:255',
            'description' => 'string|max:500',
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
}
