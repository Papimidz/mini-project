# Karhutla Monitor

Aplikasi berbasis web untuk pelaporan dan pemantauan kebakaran hutan dan lahan (Karhutla).

## Identitas Project

- Nama Project: Karhutla Monitor
- Mata Kuliah: Project 3
- Framework: Laravel
- Database: MySQL

## Fitur Utama

1. Autentikasi pengguna (Login dan Logout).
2. Pengelolaan hak akses berdasarkan role.
3. Pengelolaan wilayah pemantauan.
4. Pelaporan kejadian kebakaran hutan dan lahan.
5. Peninjauan laporan oleh Relawan.
6. Pengelolaan status tindak lanjut laporan.
7. Pencarian dan filter laporan.
8. Pemantauan laporan berdasarkan wilayah menggunakan Fetch API.
9. Dashboard rekapitulasi laporan.
10. Pencatatan perubahan status menggunakan Eloquent Observer.

## Persyaratan Sistem

- PHP 8.2 atau lebih baru
- Composer
- MySQL
- Node.js dan NPM

## Instalasi

1. Clone repository:

   git clone https://github.com/Papimidz/mini-project.git

2. Masuk ke folder project:

   cd mini-project

3. Install dependency:

   composer install
   npm install

4. Salin file konfigurasi:

   cp .env.example .env

5. Generate application key:

   php artisan key:generate

6. Buat database bernama `karhutla_monitor`.

7. Sesuaikan konfigurasi database pada file `.env`.

8. Jalankan migrasi dan Seeder:

   php artisan migrate --seed

9. Buat symbolic link storage:

   php artisan storage:link

10. Jalankan aplikasi:

    php artisan serve

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Pelapor | pelapor@karhutla.test | password123 |
| Relawan | relawan@karhutla.test | password123 |
| Koordinator | koordinator@karhutla.test | password123 |

## Struktur Role

- Pelapor: Membuat laporan dan melihat laporan miliknya.
- Relawan: Meninjau laporan dan memberikan catatan.
- Koordinator: Mengelola wilayah dan memantau tindak lanjut laporan.

## Penyimpanan Bukti

Bukti laporan disimpan menggunakan Laravel Storage pada disk public.

## Repository

https://github.com/Papimidz/mini-project