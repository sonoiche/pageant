<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        return [
            'fname'     => 'required',
            'lname'     => 'required',
            'password'  => 'nullable|sometimes|min:8|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'fname.required'    => 'The first name field is required.',
            'lname.required'    => 'The last name field is required.'
        ];
    }
}
