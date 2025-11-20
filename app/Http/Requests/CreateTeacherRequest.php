<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeacherRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'=>[
                'required',
                'string',
                'max:200'
            ],
            'email'=>[
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],

            'phone_number'=>[
                'nullable',
                'digits:10',
                'string',
                'max:255'
            ],

        ];

        return $rules;
    }
}
