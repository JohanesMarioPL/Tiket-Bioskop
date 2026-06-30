# Tiket Bioskop — Sistem Pemesanan Tiket Bioskop

Aplikasi web berbasis **Laravel** untuk pemesanan tiket bioskop secara online. Proyek ini dikembangkan sebagai tugas akhir mata kuliah **Pola Desain Perangkat Lunak** dengan mengimplementasikan berbagai *design pattern* seperti Strategy, Decorator, Factory, Observer, Abstract Factory, dan Chain of Responsibility.

---

## Persyaratan Sistem

Pastikan perangkat Anda sudah memiliki software berikut sebelum menjalankan proyek:

| Software | Versi Minimum |
|---|---|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18.x+ |
| npm | 9.x+ |
| MySQL / MariaDB | 8.0+ |

---

## Cara Menjalankan di Lokal

### 1. Clone Repository

```bash
git clone https://github.com/JohanesMarioPL/Tiket-Bioskop.git
cd Tiket-Bioskop
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency JavaScript

```bash
npm install
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buka file `.env` dan sesuaikan bagian berikut dengan konfigurasi database lokal Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tiket_bioskop
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan:** Pastikan database dengan nama `tiket_bioskop` (atau nama sesuai konfigurasi Anda) sudah dibuat terlebih dahulu di MySQL.

### 7. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan membuat seluruh tabel dan mengisi data awal (film, jadwal, studio, lokasi, dan akun pengguna) secara otomatis.

### 8. Build Asset Frontend

```bash
npm run dev
```

> Biarkan terminal ini tetap berjalan. Buka terminal baru untuk langkah berikutnya.

### 9. Jalankan Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di **http://127.0.0.1:8000**

---

## 👤 Daftar Akun yang Dapat Digunakan

> Semua akun menggunakan password yang sama: **`password`**

### Akun Admin

| Nama | Email | Password | Role |
|---|---|---|---|
| Admin | admin@example.com | password | Admin |

Akun admin memiliki akses ke panel **Admin Dashboard** (`/admin-dashboard`) untuk mengelola film, jadwal, studio, lokasi, pengguna, dan melihat laporan analitik.

### Akun User

| Nama | Email | Password | Role |
|---|---|---|---|
| John Doe | john@gmail.com | password | User |
| Jane Doe | jane@gmail.com | password | User |
| Kyle Smith | kyle@gmail.com | password | User |
| Lily Johnson | lily@gmail.com | password | User |
| Phenix Lee | phenix@gmail.com | password | User |
| Vivian Chen | vivian@gmail.com | password | User |
| William Brown | william@gmail.com | password | User |
| Marcus Davis | marcus@gmail.com | password | User |
| Michael Scott | michael@gmail.com | password | User |

---

## Struktur Design Pattern

| Design Pattern | Kategori | Lokasi File |
|---|---|---|
| Abstract Factory | Creational | `app/DesignPatterns/StudioFactory/` |
| Factory Method | Creational | `app/Factories/TicketFactory.php` |
| Decorator | Structural | `app/Services/Pricing/` |
| Strategy | Behavioral | `app/Services/Payment/` |
| Observer | Behavioral | `app/Observers/TransactionObserver.php` |
| Chain of Responsibility | Behavioral | Middleware di `routes/web.php` |

---

## Catatan Tambahan

- Fitur pembayaran menggunakan **simulasi internal** (bukan payment gateway asli), sehingga tidak ada uang nyata yang diproses.
- Setelah pembayaran disimulasikan berhasil, E-Ticket akan otomatis diterbitkan dan kursi akan berubah status menjadi terisi.
- Untuk mengakses Admin Dashboard, login menggunakan akun admin dan sistem akan otomatis mengarahkan ke halaman `/admin-dashboard`.
