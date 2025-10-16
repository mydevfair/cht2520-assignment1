<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorised to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s\-\']+$/',
            'age' => 'required|integer|min:0|max:150',
            'sex' => 'required|in:Male,Female',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'phone' => [
                'required',
                'regex:/^(?:(?:\+44\s?|0)(?:\d\s?){10})$/',
            ]
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The patient name is required.',
            'name.string' => 'The patient name must be text.',
            'name.max' => 'The patient name cannot exceed 50 characters.',
            'name.regex' => 'The patient name may only contain letters, spaces, hyphens, and apostrophes.',

            'age.required' => 'The patient age is required.',
            'age.integer' => 'The age must be a valid number.',
            'age.min' => 'The age cannot be negative.',
            'age.max' => 'The age cannot exceed 150 years.',

            'sex.required' => 'Please select the patient\'s sex.',
            'sex.in' => 'Please select a valid sex option (Male or Female).',

            'blood_type.required' => 'The blood type is required.',
            'blood_type.in' => 'Please select a valid blood type (A+, A-, B+, B-, AB+, AB-, O+, or O-).',

            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'Please enter a valid UK phone number with digits only (e.g., 01234567890 or +44 1234 567890).',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'patient name',
            'age' => 'age',
            'sex' => 'sex',
            'blood_type' => 'blood type',
            'phone' => 'phone number',
        ];
    }
}
