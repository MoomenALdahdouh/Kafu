<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
        $company_id = '';
        if (auth('web')->user()->can('incubator'))
            $company_id = 'required';
        return [
            'name' => 'required',
            'salary' => 'required',
            'company_id' => $company_id,
        ];
    }
}
