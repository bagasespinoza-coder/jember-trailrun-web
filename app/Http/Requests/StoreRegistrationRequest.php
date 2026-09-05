<?php

namespace App\Http\Requests;

use App\Models\Registration;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Data Diri
            'full_name'       => ['required', 'string', 'max:255', "regex:/^[a-zA-Z\s\.\']+$/"],
            'identity_number' => ['required', 'numeric', 'digits_between:15,17'], 
            'gender'          => ['required', 'in:L,P'],
            'pob'             => ['required', 'string', 'max:100'],
            'dob'             => ['required', 'date', 'before:today'],
            'usia'            => ['nullable', 'integer'],
            'address'         => ['required', 'string'], 
            'community'       => ['nullable', 'string', 'max:100'],

            // Kontak & Sosmed
            'whatsapp_number'  => ['required', "regex:/^(0|\+?62)8[0-9]{7,13}$/"], 
            'email'            => ['required', 'email:rfc', 'max:255'],
            'instagram_handle' => ['nullable', 'string', 'max:100'],

            // Event & Medis
            'bib_name'        => ['required', 'string', 'max:50'],
            'jersey_size'     => ['required', 'in:S,M,L,XL,XXL'],
            'blood_type'      => ['required', 'in:A,B,AB,O'], 
            'medical_history' => ['nullable', 'string'],

            // Kontak Darurat
            'emergency_contact_name'     => ['required', 'string', 'max:255', "regex:/^[a-zA-Z\s\.\']+$/"],
            'emergency_contact_relation' => ['required', 'string', 'max:100'],
            'emergency_contact_phone'    => ['required', "regex:/^(0|\+?62)8[0-9]{7,13}$/"],
        ];
    }

    /**
     * Terjemahan Error Bahasa Indonesia
     */
    public function messages(): array
    {
        return [
            // Data Diri
            'full_name.required'       => 'Nama lengkap wajib diisi.',
            'full_name.max'            => 'Nama lengkap maksimal 255 karakter.',
            'full_name.regex'          => 'Format nama tidak valid. Hanya boleh menggunakan huruf, spasi, dan tanda baca dasar.',
            
            'identity_number.required' => 'Nomor Identitas (NIK/Passport) wajib diisi.',
            'identity_number.numeric'  => 'Nomor Identitas wajib berupa angka.',
            'identity_number.digits_between' => 'Nomor Identitas harus terdiri dari 15 hingga 17 digit angka.',
            
            'gender.required'          => 'Jenis kelamin wajib dipilih.',
            'gender.in'                => 'Pilihan jenis kelamin tidak valid.',
            
            'pob.required'             => 'Tempat lahir wajib diisi.',
            'pob.max'                  => 'Tempat lahir maksimal 100 karakter.',
            
            'dob.required'             => 'Tanggal lahir wajib diisi.',
            'dob.date'                 => 'Format tanggal lahir tidak valid.',
            'dob.before'               => 'Tanggal lahir harus sebelum hari ini.',

            'usia.required'            => 'Usia wajib terisi otomatis.',
            
            'address.required'         => 'Alamat domisili wajib diisi.',

            // Kontak & Komunikasi
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp_number.regex'    => 'Format nomor WhatsApp harus diawali "08", "628", atau "+628" dan berisi angka.',
            
            'email.required'           => 'Alamat email wajib diisi.',
            'email.email'              => 'Format alamat email tidak valid (harus mengandung @).',
            'email.max'                => 'Alamat email maksimal 255 karakter.',

            // Event Details
            'bib_name.required'        => 'Nama untuk BIB wajib diisi.',
            'bib_name.max'             => 'Nama untuk BIB maksimal 50 karakter.',
            
            'jersey_size.required'     => 'Ukuran jersey (Race Tee Size) wajib dipilih.',
            'jersey_size.in'           => 'Pilihan ukuran jersey tidak valid.',

            // Profil Medis & Kontak Darurat
            'blood_type.required'      => 'Golongan darah wajib dipilih.',
            'blood_type.in'            => 'Pilihan golongan darah tidak valid.',
            
            'emergency_contact_name.required' => 'Nama kontak darurat wajib diisi.',
            'emergency_contact_name.regex'    => 'Format nama kontak tidak valid. Hanya boleh menggunakan huruf dan spasi.',
            
            'emergency_contact_relation.required' => 'Hubungan kontak darurat wajib dipilih/diisi.',
            
            'emergency_contact_phone.required'    => 'Nomor telepon darurat wajib diisi.',
            'emergency_contact_phone.regex'       => 'Format nomor telepon darurat harus diawali "08", "628", atau "+628" dan berisi angka.',
        ];
    }
}