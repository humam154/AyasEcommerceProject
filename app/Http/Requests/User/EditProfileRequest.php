<?php

namespace App\Http\Requests\User;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class EditProfileRequest extends FormRequest
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
            'first_name' => [
                'string',
                'max:255',
            ],

            'last_name' => [
                'string',
                'max:255',
            ],

            'phone' => [
                'regex:/^\d{10}$/',
                'unique:users,phone',
            ],

            'gender' => [
                'nullable',
                'in:M,F',
            ],

            'birth_date' => [
                'nullable',
                'date',
            ],

            'image' => [
                'nullable',
                'mimes:jpeg,png,jpg,svg,webp,bmp,tiff,tif,heif,heic,ico',
                'image',
                'max:4096',
            ],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Throw new ValidationException($validator, Response::Validation([], $validator->errors()));
    }
}
