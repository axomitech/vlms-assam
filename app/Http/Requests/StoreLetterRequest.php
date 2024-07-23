<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LetterPriority;
use App\Models\LetterCategory;

class StoreLetterRequest extends FormRequest
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

            'priority'=>'required|numeric|min:1|max:'.LetterPriority::max('id'),
            'category'=>'required|numeric|min:1|max:'.LetterCategory::max('id'),
            'letter'=>'required|mimes:jpg,pdf,png,jpeg|min:50|max:10000',
            'letter_no'=>'required|alpha_num',
            'letter_date'=>'required|date|date_format:Y-m-d',
            'received_date'=>'required|date|date_format:Y-m-d',
            'diary_date'=>'required|date|date_format:Y-m-d',
            'subject'=>'required',
            'sender_name'=>'required',
            'sender_designation'=>'required',
            'sender_mobile'=>'required|string|min:10|max:10',
            'sender_email'=>'required|email',
            'organization'=>'required',
            'address'=>'required',
        ];
    }

    public function messages(): array
    {
        return [

            'priority.required'=>'Please select letter priority.',
            'priority.numeric'=>'Please select a valid letter priority.',
            'priority.min'=>'Please select a valid letter priority.',
            'priority.max'=>'Please select a valid letter priority.',
            'category.required'=>'Please select letter category.',
            'category.numeric'=>'Please select a valid letter category.',
            'category.min'=>'Please select a valid letter category.',
            'category.max'=>'Please select a valid letter category.',
            'letter.required'=>'Please select a letter file.',
            'letter.mimes'=>'Please select a letter file in jpg,pdf,png or jpeg format.',
            'letter.min'=>'Please select a letter file with minimum size 50Kb.',
            'letter.max'=>'Please select a letter file with maximum size 1Mb',
            'letter_no.required'=>'Please provide a letter number.',
            'letter_no.alpha_num'=>'Please provide a valid letter number.',
            'letter_date.required'=>'Please provide the date of letter.',
            'letter_date.date'=>'Please provide a valid date of letter.',
            'letter_date.date_format'=>'Please provide a valid date of letter.',
            'received_date.required'=>'Please provide the date of letter received.',
            'received_date.date'=>'Please provide a valid date of letter received.',
            'received_date.date_format'=>'Please provide a valid date of letter received.',
            'diary_date.required'=>'Please provide the date of letter diary.',
            'diary_date.date'=>'Please provide a valid date of letter diary.',
            'diary_date.date_format'=>'Please provide a valid date of letter diary.',
            'subject.required'=>'Please provide letter subject.',
            'sender_name.required'=>'Please provide sender name.',
            'sender_designation.required'=>'Please provide sender designation.',
            'sender_mobile.required'=>'Please provide sender mobile.',
            'sender_mobile.string'=>'Please provide a valid sender mobile.',
            'sender_mobile.min'=>'Please provide a valid sender mobile.',
            'sender_mobile.max'=>'Please provide a valid sender mobile.',
            'sender_email.required'=>'Please provide sender email.',
            'sender_email.email'=>'Please provide a valid sender email.',
            'organization.required'=>'Please provide sender\'s organization.',
            'address.required'=>'Please provide address of the sender\'s organization.',
            'address.alpha_num'=>'Please provide valid address of the sender\'s organization.',
        ];
    }
}