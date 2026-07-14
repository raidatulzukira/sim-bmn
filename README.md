# Sistem Informasi Monitoring dan Pengelolaan Aset BMN Berbasis Web

Proyek ini adalah "Sistem Informasi Monitoring dan Pengelolaan Aset BMN Berbasis Web" untuk Balai Diklat Industri (BDI) Padang. 
Sistem ini dibangun sebagai bagian dari Tugas Akhir.

## Fitur Utama

- Kelola aset BMN dan kelola ruangan.
- Peminjaman dan pengembalian aset.
- Pemeliharaan/servis aset.
- Notifikasi otomatis via WhatsApp Gateway.
- Laporan (PDF & Excel).

## Tech Stack

- **Framework**: Laravel (versi terbaru/LTS)
- **View Engine**: Blade
- **Database**: MySQL
- **Autentikasi**: Laravel Breeze
- **Laporan PDF**: barryvdh/laravel-dompdf
- **Laporan Excel**: maatwebsite/excel

## Role Pengguna

Sistem ini mendukung 3 role pengguna utama:
1. **Operator** (Admin lokal)
2. **Kasubag TU** (Approval)
3. **Pegawai** (End-user)

## Cara Menjalankan Proyek Secara Lokal

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan pengembangan (lokal):

1. **Clone repository:**
   ```bash
   git clone <repository-url>
   cd sim-bmn
   ```

2. **Install dependency PHP:**
   ```bash
   composer install
   ```

3. **Install dependency Node.js:**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database `sim_bmn_db`.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Jalankan Migrasi Database:**
   (Pastikan database `sim_bmn_db` telah dibuat di MySQL)
   ```bash
   php artisan migrate
   ```

6. **Jalankan Server Pengembangan:**
   Buka dua terminal dan jalankan perintah berikut secara bersamaan:
   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```

7. **Akses Aplikasi:**
   Buka browser dan navigasikan ke: [http://localhost:8000](http://localhost:8000)
