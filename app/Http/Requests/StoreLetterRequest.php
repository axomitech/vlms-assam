<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LetterPriority;
use App\Models\LetterCategory;
use App\Models\LetterSubCategory;
use Carbon\Carbon;

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
        $today = Carbon::now()->format('Y-m-d');
        return [

            'priority' => 'required|numeric|min:1|max:' . LetterPriority::max('id'),
            'category' => 'required|numeric|min:1|max:' . LetterCategory::max('id'),
            'sub_category' => 'nullable|required_if:category,7,8|numeric|min:1|max:' . LetterSubCategory::max('id'),
            'other_sub_category' => 'nullable|required_if:category,10|string',
            'letter' => 'required|mimes:jpg,pdf,png,jpeg|min:50|max:10000',
            'letter_no' => 'required',
            'letter_date' => 'required|date|date_format:Y-m-d|before_or_equal:' . $today,
            'received_date' => 'required|date|date_format:Y-m-d|before_or_equal:' . $today,
            'diary_date' => 'required|date|date_format:Y-m-d|before_or_equal:' . $today,
            'subject' => 'required',
            'receipt' => 'required|in:0,1',
            'legacy' => 'required|in:0,1',
            // Conditional validation based on receipt value
            'sender_name' => 'required_if:receipt,1',
            'sender_designation' => 'required_if:receipt,1',
            'sender_mobile' => 'nullable',
            'sender_email' => 'nullable|email',
            'recipient_name' => 'required_if:receipt,0',
            'recipient_designation' => 'required_if:receipt,0',
            'recipient_mobile' => 'nullable',
            'recipient_email' => 'nullable|email',
            'organization' => 'required',
            'address' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [

            'priority.required' => 'Please select letter priority.',
            'priority.numeric' => 'Please select a valid letter priority.',
            'priority.min' => 'Please select a valid letter priority.',
            'priority.max' => 'Please select a valid letter priority.',
            'category.required' => 'Please select letter category.',
            'category.numeric' => 'Please select a valid letter category.',
            'category.min' => 'Please select a valid letter category.',
            'category.max' => 'Please select a valid letter category.',
            'sub_category.required' => 'Please select letter sub category.',
            'sub_category.numeric' => 'Please select a valid letter sub category.',
            'sub_category.min' => 'Please select a valid letter sub category.',
            'sub_category.max' => 'Please select a valid letter sub category.',
            'letter.required' => 'Please select a letter file.',
            'letter.mimes' => 'Please select a letter file in jpg,pdf,png or jpeg format.',
            'letter.min' => 'Please select a letter file with minimum size 50Kb.',
            'letter.max' => 'Please select a letter file with maximum size 1Mb',
            'letter_no.required' => 'Please provide a letter number.',
            'letter_no.alpha_num' => 'Please provide a valid letter number.',
            'letter_date.required' => 'Please provide the date of letter.',
            'letter_date.date' => 'Please provide a valid date of letter.',
            'letter_date.date_format' => 'Please provide a valid date of letter.',
            'letter_date.before_or_equal' => 'Please provide a current date or before.',
            'received_date.required' => 'Please provide the date of letter received.',
            'received_date.date' => 'Please provide a valid date of letter received.',
            'received_date.date_format' => 'Please provide a valid date of letter received.',
            'received_date.before_or_equal' => 'Please provide current date or before.',
            'diary_date.required' => 'Please provide the date of letter diary.',
            'diary_date.date' => 'Please provide a valid date of letter diary.',
            'diary_date.date_format' => 'Please provide a valid date of letter diary.',
            'diary_date.before_or_equal' => 'Please provide current date or before.',
            'subject.required' => 'Please provide letter subject.',
            'sender_name.required' => 'Please provide sender name.',
            'sender_designation.required' => 'Please provide sender designation.',
            'sender_mobile.required' => 'Please provide sender mobile.',
            'sender_mobile.string' => 'Please provide a valid sender mobile.',
            'sender_mobile.min' => 'Please provide a valid sender mobile.',
            'sender_mobile.max' => 'Please provide a valid sender mobile.',
            'sender_email.required' => 'Please provide sender email.',
            'sender_email.email' => 'Please provide a valid sender email.',
            'recipient_name.required' => 'Please provide recipient name.',
            'recipient_designation.required' => 'Please provide recipient designation.',
            'recipient_mobile.required' => 'Please provide recipient mobile.',
            'recipient_mobile.string' => 'Please provide a valid recipient mobile.',
            'recipient_mobile.min' => 'Please provide a valid recipient mobile.',
            'recipient_mobile.max' => 'Please provide a valid recipient mobile.',
            'recipient_email.required' => 'Please provide recipient email.',
            'recipient_email.email' => 'Please provide a valid recipient email.',
            'organization.required' => 'Please provide organization.',
            'address.required' => 'Please provide address of the organization.',
            'address.alpha_num' => 'Please provide valid address of the organization.',
        ];
    }
}
