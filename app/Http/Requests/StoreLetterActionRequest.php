<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department;
use App\Models\LetterPriority;

class StoreLetterActionRequest extends FormRequest
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

            "letter_action"=>"required",
            "departments"    => "required|array|min:1",
            "departments.*"  => "required|numeric|distinct|min:".Department::min('id').'|max:'.Department::max('id'),
            "letter"=>"required|numeric|min:1",
        ];
    }

    public function messages(): array
    {
        return [

            "letter_action.required"=>"Please provide letter action.",
            "departments.required"    => "Please select a department.",
            "departments.array"    => "Please select a valid department.",
            "departments.min"    => "Please select atleast one department.",
            "departments.*.required"  => "Please select a department.",
            "departments.*.numeric"  => "Please select a valid department.",
            "departments.*.distinct"  => "Please select a valid department.",
            "departments.*.min"  => "Please select a valid department.",
            "departments.*.max"  => "Please select a valid department.",
            "letter.required"=>"Letter is required.",
            "letter.numeric"=>"Please provide a valid letter.",
            "letter.min"=>"Please provide a valid letter.",

        ];
    }
}
