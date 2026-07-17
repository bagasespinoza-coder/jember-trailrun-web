# Jember 10K Trail Run - Web Registration & Payment System
Official web landing page and automated registration system for 10K Trail Run Jember, developed by Aksara. Built with Laravel and Midtrans QRIS

## Fitur Utama (Features)
* **Responsive Landing Page:** Desain modern, kencang, dan adaptif (Mobile & Desktop) menggunakan Tailwind CSS.
* **Automated QRIS Payment:** Integrasi pembayaran instan menggunakan Midtrans Snap API yang dikunci khusus untuk metode QRIS.
* **Real-Time Spreadsheet Sync:** Sinkronisasi data peserta otomatis secara *real-time* ke Google Sheets via Make.com begitu status pembayaran `settlement`.
* **Automated Email Ticket:** Pengiriman email konfirmasi dan nomor BIB digital secara otomatis via Brevo SMTP.
* **Hard-Capped Quota Validation:** Sistem validasi kuota ketat di sisi backend untuk mengunci pendaftaran tepat di 300 peserta.

## Tech Stack
* **Frontend:** Laravel Blade, Tailwind CSS, Alpine.js
* **Backend:** Laravel 11.x, Midtrans PHP SDK
* **Database:** MySQL
* **Automation & Tools:** Make.com (Webhook Integrator), Brevo (SMTP), Expose (Local Tunneling)

## Persyaratan Sistem (Prerequisites)
Sebelum menjalankan proyek ini di localhost, pastikan laptop lu sudah ter-install:
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL Server (XAMPP / Laragon)
