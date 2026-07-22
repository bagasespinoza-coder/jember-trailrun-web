# 🏃 Jember 10K Trail Run - Web Registration & Payment System

> Official web landing page and automated registration system for **Jember 10K Trail Run**, developed by **Aksara**. Built with **Laravel 11** & **Midtrans QRIS**.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Midtrans](https://img.shields.io/badge/Midtrans-Snap_API-blue?style=for-the-badge)

---

## 🌟 Fitur Utama (Features)

* **Responsive Landing Page**: Desain modern, kencang, dan adaptif (Mobile & Desktop) menggunakan Tailwind CSS dan Alpine.js.
* **Automated QRIS Payment**: Integrasi pembayaran instan menggunakan Midtrans Snap API yang dikunci khusus untuk metode QRIS.
* **Real-Time Spreadsheet Sync**: Sinkronisasi data peserta otomatis secara real-time ke Google Sheets via Make.com begitu status pembayaran *settlement*.
* **Automated Email Ticket**: Pengiriman email konfirmasi dan nomor BIB digital secara otomatis via Brevo SMTP.
* **Hard-Capped Quota Validation**: Sistem validasi kuota ketat di sisi backend untuk mengunci pendaftaran tepat di **300 peserta**.

---

## 🚀 Metodologi Pengembangan (Scrum Framework)

Proyek ini dikembangkan menggunakan metodologi Scrum dengan total waktu pengerjaan produk selama **14 hari (2 Minggu)**, yang dipecah ke dalam **4 Sprint taktis**. Sisa waktu 2 minggu setelah produk matang dialokasikan penuh untuk proses *deployment testing*, *security hardening*, dan *load simulation*.

### 📍 Pelacakan Tugas & Project Management
> Seluruh Product Backlog, pembagian tugas (*Assignee*), pelacakan Sprint, hingga pemantauan status kerja (*Todo*, *In Progress*, *Done*) dikelola secara transparan dan terintegrasi di: 
> ➡️ **[Tab Projects di bagian atas Repositori GitHub ini]**

### 📅 Rincian Pembagian Sprint (14 Hari):

* **Sprint 1 (Hari 1-3) - Design & Foundation**: Fokus pada pembuatan UI/UX di Figma dan inisialisasi arsitektur database (*Migration & Model*) di Laravel.
* **Sprint 2 (Hari 4-7) - Slicing & Form Validation**: Proses slicing desain ke Laravel Blade + Tailwind CSS, sekaligus pengamanan validasi input form dan sistem penguncian kuota 300 peserta.
* **Sprint 3 (Hari 8-12) - Advanced Automation Engine**: Integrasi inti Midtrans Snap API (QRIS), otomatisasi webhook response real-time ke Make.com (Google Sheets), dan penyiapan sistem email SMTP Brevo.
* **Sprint 4 (Hari 13-14) - End-to-End Internal Testing**: Uji coba simulasi transaksi massal via Expose & Midtrans Simulator, pembabatan bug, serta validasi *Signature Key security*.

---

## 🎨 Figma Design

🎨 **[Lihat Desain Figma JTR x Aksara](https://www.figma.com/design/Z4Kcjkpn2ODlCtaRrojPTo/JTR-X-Aksara?node-id=0-1&p=f&t=RlV3WFHEuIdnAm7S-0)**

---

## 🛠️ Tech Stack

* **Frontend**: Laravel Blade, Tailwind CSS, Alpine.js
* **Backend**: Laravel 11.x, Midtrans PHP SDK
* **Database**: MySQL
* **Automation & Tools**: Make.com (Webhook Integrator), Brevo (SMTP), Expose (Local Tunneling)

---

## 💻 Cara Instalasi & Menjalankan Proyek

### Prerequisites
Pastikan perangkat lokal sudah ter-install:
* PHP >= 8.2
* Composer
* Node.js (v18+) & NPM
* MySQL Server (XAMPP / Laragon)

### Langkah Instalasi

1. **Clone Repositori**
   ```bash
   git clone [https://github.com/username/jember-trail-run.git](https://github.com/username/jember-trail-run.git)
   cd jember-trail-run
   
2. **Install Dependensi PHP & Node**
   ```bash
   composer install
   npm install
   
3. **Konfigurasi Environment**
    Duplicate file .env.example menjadi .env:
    ```bash
    cp .env.example .env
    
Atur kredensial berikut di .env:
    ```code snippet
    DB_DATABASE=jember_trail_run
    DB_USERNAME=root
    DB_PASSWORD=
    
    MIDTRANS_SERVER_KEY=your_midtrans_server_key
    MIDTRANS_CLIENT_KEY=your_midtrans_client_key
    MIDTRANS_IS_PRODUCTION=false
    
    MAIL_MAILER=smtp
    MAIL_HOST=smtp-relay.brevo.com
    MAIL_PORT=587
    MAIL_USERNAME=your_brevo_username
    MAIL_PASSWORD=your_brevo_password
    
    MAKE_WEBHOOK_URL=your_make_webhook_url
    
4. **Generate App Key & Run Migration**
    ```bash
    php artisan key:generate
    php artisan migrate

5. **Jalankan Development Server**
    ```bash
    # Jalankan server Laravel
    php artisan serve
    # Jalankan Vite compiler
    npm run dev
