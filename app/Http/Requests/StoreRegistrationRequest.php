<?php

namespace App\Http\Requests;

use App\Models\Registration;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Data Diri
            'full_name' => ['required', 'string', 'max:255'],
            'identity_number' => ['required', 'string', 'max:50', 'unique:registrations,identity_number'],
            'gender' => ['required', 'in:L,P'],
            'pob' => ['required', 'string', 'max:100'],
            'dob' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string'],
            'community' => ['nullable', 'string', 'max:100'],

            // Kontak & Sosmed
            'whatsapp_number' => ['required', 'numeric', 'digits_between:8,15'], 
            'email' => ['required', 'email:rfc,dns', 'max:255'], 
            'instagram_handle' => ['nullable', 'string', 'max:100'],

            // Event & Medis
            'category' => ['required', 'string'],
            'jersey_size' => ['required', 'in:S,M,L,XL,XXL'],
            'blood_type' => ['nullable', 'in:A,B,AB,O'],
            'medical_history' => ['nullable', 'string'],
            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'emergency_contact_relation' => ['required', 'string', 'max:100'],
            'emergency_contact_phone' => ['required', 'numeric', 'digits_between:8,15'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (Registration::isQuotaFull()) {
                $validator->errors()->add('quota', 'Mohon maaf, kuota pendaftaran 300 peserta sudah penuh. Harap Hubungi Panitia');
            }
        });
    }
}
