<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReferenceRequest extends FormRequest
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

            "refer_letters"    => "required|array",
            "refer_letters.*"  => "required|string",
            "assign_letter"=>"required|numeric|min:1",
        ];
    }

    public function messages(): array
    {
        return [

            "refer_letters.required"    => "Please select a reference letter.",
            "refer_letters.array"    => "Please select a valid reference letter.",
            "refer_letters.*.required"  => "Please select a reference letter.",
            "departments.*.string"  => "Please select a valid reference letter.",
            "departments.*.distinct"  => "Please select a valid department.",
            "assign_letter.required"=>"Letter is required.",
            "assign_letter.numeric"=>"Please provide a valid letter.",
            "assign_letter.min"=>"Please provide a valid letter.",

        ];
    }
}
