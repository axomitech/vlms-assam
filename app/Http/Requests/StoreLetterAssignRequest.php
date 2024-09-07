<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserDepartment;
use App\Models\Letter;

class StoreLetterAssignRequest extends FormRequest
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

            'assignee'=>'required|numeric|min:1|max:'.UserDepartment::max('id'),
            'assign_letter'=>'required|numeric|min:1|max:'.Letter::max('id'),
            'assign_remarks'=>'required'
        ];
    }

    public function messages(): array
    {
        return [

            'assignee.required'=>'Please select an assignee.',
            'assignee.numeric'=>'Please select an valid assignee.',
            'assignee.min'=>'Please select an valid assignee.',
            'assignee.max'=>'Please select an valid assignee.',
            'assign_remarks.required'=>'Please provide remarks.'
        ];
    }
}
