# LIBSYS (Library Management System)

## System Requirement

Untuk menjalankan aplikasi ini, Anda memerlukan:

- PHP versi 8.0 atau lebih baru
- Composer
- MySQL atau database lainnya yang didukung Laravel
- Node.js dan NPM (Opsional)

## Cara Install

Berikut adalah langkah-langkah untuk mengkloning proyek ini dan menginstalnya di lingkungan lokal Anda:

1. **Kloning Repositori**

   Pertama, kloning repositori ini ke direktori lokal Anda menggunakan perintah git:

   ```bash
   git clone https://github.com/damaskus92/libsys-api.git
   ```

2. **Masuk ke Direktori Proyek**

   Pindah ke direktori proyek yang baru saja dikloning:

   ```bash
   cd libsys-api
   ```

3. **Install Dependensi PHP dengan Composer**

   Jalankan perintah berikut untuk menginstal semua dependensi PHP yang diperlukan:

   ```bash
   composer install
   ```

4. **Install Dependensi JavaScript dengan NPM (Opsional)**

   Untuk mengelola dependensi front-end dan mengkompilasi asset, jalankan:

   ```bash
   npm install
   npm run dev
   ```

5. **Salin File `.env`**

   Buat salinan dari file `.env.example` dan beri nama `.env`:

   ```bash
   cp .env.example .env
   ```

6. **Atur Kunci Aplikasi**

   Buat kunci aplikasi baru dengan perintah berikut:

   ```bash
   php artisan key:generate
   ```

7. **Konfigurasi Database**

   Buka file `.env` dan sesuaikan konfigurasi database sesuai dengan pengaturan lokal Anda:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=libsys
   DB_USERNAME=root
   DB_PASSWORD=
   ```

8. **Migrasi dan Seeding Database**

   Jalankan migrasi untuk membuat tabel database dan seeder untuk mengisi data awal (jika ada):

   ```bash
   php artisan migrate --seed
   ```

9. **Jalankan Server Aplikasi**

   Jalankan server pengembangan Laravel menggunakan perintah berikut:

   ```bash
   php artisan serve
   ```

   Aplikasi akan berjalan di <http://localhost:8000>.

## Pengujian

Untuk menjalankan pengujian, kita dapat menggunakan file `.env.testing` untuk konfigurasi lingkungan pengujian.

1. **Buat File `.env.testing`**

   Buat file `.env.testing` dengan menyalin file `.env`:

   ```bash
   cp .env .env.testing
   ```

   Ubah pengaturan database di `.env.testing` sesuai dengan database pengujian Anda:

   ```bash
   DB_CONNECTION=sqlite
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Buat Database Pengujian**

   Buat database SQlite untuk pengujian:

   ```bash
   touch database/database.sqlite
   ```

3. **Jalankan Pengujian**

   Gunakan perintah di bawah ini untuk menjalankan pengujian:

   ```bash
   php artisan test
   ```

## Author

### [Damas Eka Kusuma](https://github.com/damaskus92)
