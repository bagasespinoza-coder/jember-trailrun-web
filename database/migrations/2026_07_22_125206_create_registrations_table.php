<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            // 1. Data Diri
            $table->string('full_name');
            $table->string('identity_number'); // NIK / Paspor
            $table->enum('gender', ['L', 'P']);
            $table->string('pob');
            $table->date('dob'); 
            $table->integer('usia')->nullable();
            $table->text('address');
            $table->string('community')->nullable(); // Opsional

            // 2. Kontak & Sosial Media
            $table->string('whatsapp_number')->index(); // Index untuk pencarian cepat
            $table->string('email')->index(); // Index untuk pencarian cepat / emailer
            $table->string('instagram_handle')->nullable(); // Opsional

            // 3. Detail Event & Logistics
            $table->string('bib_name')->nullable(); // Nama custom di BIB
            $table->string('bib_number')->nullable()->unique(); // Nomor BIB (cth: M10001, F10002)
            $table->string('category')->default('10K'); // Misal: 10K, 21K
            $table->enum('jersey_size', ['S', 'M', 'L', 'XL', 'XXL']);

            // 4. Medis & Kontak Darurat 
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->text('medical_history')->nullable(); // Alergi / penyakit bawaan
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_relation');
            $table->string('emergency_contact_phone');

            // 5. Status Pembayaran / Registrasi
            $table->string('order_id')->unique(); // Kode transaksi
            $table->string('payment_status')->default('pending'); // STRING agar kompatibel Midtrans/Manual
            $table->string('snap_token')->nullable(); // Tempat simpan token Midtrans
            $table->string('payment_proof')->nullable(); // Path file bukti transfer manual
            $table->unsignedBigInteger('gross_amount'); // Nominal pembayaran
            $table->timestamp('paid_at')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};