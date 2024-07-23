<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ActionStatus;

class ActionResponseRequest extends FormRequest
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
            'action_response'=>'required|mimes:jpg,pdf,png,jpeg|min:50|max:10000',
            'action_status'=>'required|numeric|min:1|max:'.ActionStatus::max('id'),
            'note'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            
            'action_response.required'=>'Please select a response file.',
            'action_response.mimes'=>'Please select a response file in jpg,pdf,png or jpeg format.',
            'action_response.min'=>'Please select a response file with minimum size 50Kb.',
            'action_response.max'=>'Please select a response file with maximum size 1Mb',
            'action_status.required'=>'Please select response status.',
            'action_status.numeric'=>'Please select a valid response status.',
            'action_status.min'=>'Please select a valid response status.',
            'action_status.max'=>'Please select a valid response status.',
            'note.required'=>'Please provide response note.',
        ];
    }
}
