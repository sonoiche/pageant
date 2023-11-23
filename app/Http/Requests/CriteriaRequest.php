<?php

namespace App\Http\Requests;

use App\Rules\CheckCriteria;
use Illuminate\Foundation\Http\FormRequest;

class CriteriaRequest extends FormRequest
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
        $contest_id = $this->input('contest_id');
        return [
            'contest_id'    => 'required',
            'name'          => 'required',
            'percentage'    => [
                'required',
                'min:1',
                'max:2',
                new CheckCriteria($contest_id)
            ]
        ];
    }

    public function messages()
    {
        return [
            'contest_id.required'   => 'The contest field is required.',
            'name.required'         => 'The criteria field is required.'
        ];
    }
}
