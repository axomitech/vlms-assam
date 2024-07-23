<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department;

class StoreActionSentRequest extends FormRequest
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

            'action_map'=>'required|array|min:1',
            'action_map.*'=>'required|numeric|min:1',
            'action_dept'=>'required|array|min:1',
            'action_dept.*'=>'required|numeric|min:'.Department::min('id').'|max:'.Department::max('id'),
            'forward_letter'=>'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [

            'action_map.required'=>'Please provide valid data.',
            'action_map.array'=>'Please provide valid data.',
            'action_map.min'=>'Please provide valid data.',
            'action_map.*.required'=>'Please provide valid data.',
            'action_map.*.numeric'=>'Please provide valid data.',
            'action_map.*.min'=>'Please provide valid data.',
            'action_dept.required'=>'Please provide valid data.',
            'action_dept.array'=>'Please provide valid data.',
            'action_dept.min'=>'Please provide valid data.',
            'action_dept.*.required'=>'Please provide valid data.',
            'action_dept.*.numeric'=>'Please provide valid data.',
            'action_dept.*.min'=>'Please provide valid data.',
            'action_dept.*.max'=>'Please provide valid data.',
            'forward_letter.required'=>'Please provide valid data.',
            'forward_letter.numeric'=>'Please provide valid data.',
            'forward_letter.min'=>'Please provide valid data.',

        ];
    }
}
