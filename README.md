# Jember 10K Trail Run - Web Registration & Payment System
Official web landing page and automated registration system for 10K Trail Run Jember, developed by Aksara. Built with Laravel and Midtrans QRIS

## Fitur Utama (Features)
* **Responsive Landing Page:** Desain modern, kencang, dan adaptif (Mobile & Desktop) menggunakan Tailwind CSS.
* **Automated QRIS Payment:** Integrasi pembayaran instan menggunakan Midtrans Snap API yang dikunci khusus untuk metode QRIS.
* **Real-Time Spreadsheet Sync:** Sinkronisasi data peserta otomatis secara *real-time* ke Google Sheets via Make.com begitu status pembayaran `settlement`.
* **Automated Email Ticket:** Pengiriman email konfirmasi dan nomor BIB digital secara otomatis via Brevo SMTP.
* **Hard-Capped Quota Validation:** Sistem validasi kuota ketat di sisi backend untuk mengunci pendaftaran tepat di 300 peserta.

## 📊 Metodologi Pengembangan (Scrum Framework)
Proyek ini dikembangkan menggunakan metodologi **Scrum** dengan total waktu pengerjaan produk selama **14 hari (2 Minggu)**, yang dipecah ke dalam 4 *Sprint* taktis. Sisa waktu 2 minggu setelah produk matang akan dialokasikan penuh untuk proses *deployment testing, security hardening,* dan *load simulation*.

### 📍 Dimana Letak Manajemen Scrum Proyek Ini?
Seluruh *Product Backlog*, pembagian tugas (*Assignee*), pelacakan *Sprint*, hingga pemantauan status kerja (*Todo, In Progress, Done*) dikelola secara transparan dan terintegrasi di:
➡️ **[Tab Projects di bagian atas Repositori GitHub ini]** 

### ⏱️ Rincian Pembagian Sprint (14 Hari):
* **Sprint 1 (Hari 1-3) - Design & Foundation:** Fokus pada pembuatan UI/UX di Figma dan inisialisasi arsitektur database (Migration & Model) di Laravel.
* **Sprint 2 (Hari 4-7) - Slicing & Form Validation:** Proses *slicing* desain ke Laravel Blade + Tailwind CSS, sekaligus pengamanan validasi input form dan sistem penguncian kuota 300 peserta.
* **Sprint 3 (Hari 8-12) - Advanced Automation Engine:** Integrasi inti Midtrans Snap API (QRIS), otomatisasi *webhook response* real-time ke Make.com (Google Sheets), dan penyiapan sistem email SMTP Brevo.
* **Sprint 4 (Hari 13-14) - End-to-End Internal Testing:** Uji coba simulasi transaksi massal via Expose & Midtrans Simulator, pembabatan *bug*, serta validasi *Signature Key security*.

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
