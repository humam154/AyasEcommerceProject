<?php

namespace App\Http\Requests\Moderator;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ModeratorLoginRequest extends FormRequest
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
            'phone' => [
                'required',
                'regex:/^\d{10}$/',
            ],

            'password' => [
                'required',
                'string',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Throw new ValidationException($validator, Response::Validation([], $validator->errors()));
    }
}
