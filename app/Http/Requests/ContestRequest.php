<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestRequest extends FormRequest
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
        $id = $this->input('id');
        return [
            'title'         => 'required|unique:contests,title,'.(($id) ? $id : null).',id',
            'description'   => 'required',
            'venue'         => 'required',
            'date_held'     => 'required',
            'status'        => 'required'
        ];
    }
}
