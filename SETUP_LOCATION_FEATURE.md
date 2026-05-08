# Quick Start Guide - Fitur Pencarian Lokasi Bioskop

## 📋 Prerequisites

- PHP 8.1 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Node.js & npm (untuk build assets)

## 🚀 Setup Instructions

### 1. Clone & Setup Project

```bash
# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Konfigurasi Database

Buka `.env` dan sesuaikan database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tiket_bioskop
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Migrations & Seeders

```bash
# Run migrations
php artisan migrate

# Run seeders (untuk populate sample data)
php artisan db:seed

# Atau seed specific seeder
php artisan db:seed --class=LocationSeeder
```

### 4. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 5. Start Development Server

```bash
# Terminal 1: Start PHP server
php artisan serve

# Terminal 2: Watch assets (optional)
npm run watch
```

Server akan berjalan di: **http://localhost:8000**

## 🎯 Akses Fitur Pencarian Lokasi

### Halaman Utama Pencarian Lokasi
```
URL: http://localhost:8000/locations
```

### Halaman Pemilihan Film & Jadwal
```
URL: http://localhost:8000/location/{id}/schedules
```

### API Endpoints
```
GET  /locations              # List semua lokasi
GET  /locations/search?search=keyword
GET  /locations/city/{city}  # Lokasi by city
GET  /locations/{id}         # Detail lokasi
```

## 📊 Database Structure

### Tabel Utama untuk Fitur Lokasi

#### locations
- `id` - Primary Key
- `name` - Nama lokasi
- `city` - Kota
- `address` - Alamat lengkap
- `timestamps` - Created/Updated at

#### studios  
- `id` - Primary Key
- `location_id` - Foreign Key ke locations
- `studio_name` - Nama studio (e.g., "Studio 1")
- `studio_type` - Tipe studio (2D, 3D, 4DX, IMAX)
- `capacity` - Kapasitas kursi
- `timestamps` - Created/Updated at

## 🧪 Testing

### Manual Test - Pencarian Lokasi

1. **Buka halaman pencarian**
   - Navigasi ke: `/locations`
   - Verifikasi: Semua lokasi ditampilkan

2. **Test search functionality**
   - Ketik "Jakarta" di search box
   - Verifikasi: Hanya lokasi di Jakarta yang muncul
   - Ketik "Bandung"
   - Verifikasi: Hasil berubah

3. **Test filter tabs**
   - Klik "Populer" - verifikasi filter diterapkan
   - Klik "Terdekat" - verifikasi filter diterapkan
   - Klik "Semua Lokasi" - verifikasi semua muncul

4. **Test location selection**
   - Klik tombol "Pilih Lokasi Ini"
   - Verifikasi: Loading spinner muncul
   - Verifikasi: Redirect ke halaman schedules

5. **Test schedules page**
   - Verifikasi: Lokasi yang dipilih ditampilkan
   - Verifikasi: Breadcrumb navigation
   - Verifikasi: Step indicator

## 📁 File Structure

```
app/Http/Controllers/LocationController.php       ← Controller
app/Models/Location.php                           ← Model (sudah ada)
app/Models/Studio.php                             ← Model (sudah ada)

resources/views/locations/
├── index.blade.php                               ← Pencarian lokasi
├── show.blade.php                                ← Detail lokasi
└── schedules.blade.php                           ← Film & jadwal

routes/web.php                                    ← Routes

database/migrations/2026_05_08_070712_...        ← Migrations
database/seeders/LocationSeeder.php               ← Sample data
```

## 🔧 Troubleshooting

### Error: "Target class [LocationController] does not exist"
```bash
# Re-generate autoloader
composer dump-autoload
```

### Database connection error
```bash
# Check .env DB credentials
# Run: php artisan migrate
# Make sure MySQL is running
```

### Assets tidak ter-load
```bash
# Rebuild assets
npm run build

# Atau gunakan Vite dev server
npm run dev
```

### localStorage tidak work
- Pastikan browser support localStorage
- Check browser console untuk errors
- Bersihkan cookies/cache jika perlu

## 📱 Responsive Testing

### Mobile (320px - 640px)
- Grid: 1 kolom
- Test: Touch interactions, readability

### Tablet (641px - 1024px)
- Grid: 2 kolom
- Test: Layout adaptability

### Desktop (1025px+)
- Grid: 3 kolom
- Test: Full functionality

## 🎨 Customization

### Ubah Warna Primary
Edit di view files:
```html
<!-- Change from -->
bg-red-500  <!-- Red -->

<!-- To -->
bg-blue-500 <!-- Blue -->
```

### Ubah Jumlah Kolom Grid
Edit di `index.blade.php`:
```html
<!-- Current -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- Change to 4 columns -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
```

## 🚨 Important Notes

1. **Migration Order**: Locations table harus di-create sebelum Studios
2. **Seeders**: Jalankan LocationSeeder untuk populate data
3. **Frontend**: Menggunakan Tailwind CSS dan Font Awesome Icons
4. **Storage**: LocalStorage untuk menyimpan user selections
5. **Responsive**: Mobile-first approach dengan Tailwind breakpoints

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Font Awesome Icons](https://fontawesome.com)
- [Blade Templating](https://laravel.com/docs/blade)

## 🆘 Support

Jika menemui issue:

1. Check terminal error messages
2. Look in logs: `storage/logs/laravel.log`
3. Verify database connection
4. Clear cache: `php artisan cache:clear`
5. Compile views: `php artisan view:clear`

---

**Last Updated**: May 8, 2026  
**Version**: 1.0.0
