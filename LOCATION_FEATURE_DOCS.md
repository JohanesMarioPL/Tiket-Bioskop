# Dokumentasi Fitur Pencarian Lokasi Bioskop

## Deskripsi Fitur

Fitur pencarian lokasi bioskop memungkinkan pengguna untuk:
1. ✅ Melihat daftar semua lokasi bioskop yang tersedia
2. ✅ Mencari lokasi berdasarkan nama, kota, atau alamat
3. ✅ Memfilter lokasi berdasarkan berbagai kriteria
4. ✅ Melihat detail lengkap dari setiap lokasi (studios, fasilitas, etc)
5. ✅ Melanjutkan proses pemesanan tiket setelah memilih lokasi

Fitur ini mengikuti alur seperti aplikasi XXI di mana user harus memilih lokasi terlebih dahulu sebelum memilih film dan jadwal.

---

## Struktur File

```
app/
├── Http/
│   └── Controllers/
│       └── LocationController.php          # Controller untuk location
│
models/
├── Location.php                            # Model Location (sudah ada)
├── Studio.php                              # Model Studio (sudah ada)
│
resources/
└── views/
    └── locations/
        ├── index.blade.php                 # Halaman pencarian & list lokasi
        ├── show.blade.php                  # Halaman detail lokasi
        └── schedules.blade.php             # Halaman pemilihan film & jadwal

routes/
├── web.php                                 # Route untuk location features
```

---

## Route yang Tersedia

```php
// GET - Tampilkan halaman pencarian lokasi
GET /locations
Route name: locations.index

// GET - Cari lokasi via API
GET /locations/search?search=keyword
Route name: locations.search
Response: JSON array of locations

// GET - Tampilkan halaman film & jadwal untuk lokasi tertentu
GET /location/{id}/schedules
Route name: location.schedules

// GET - Ambil lokasi berdasarkan kota
GET /locations/city/{city}
Route name: locations.city
Response: JSON array of locations

// GET - Tampilkan detail lengkap dari lokasi
GET /locations/{location}
Route name: locations.show
```

---

## Controller Methods

### LocationController@index
- **Tujuan**: Menampilkan halaman utama pencarian lokasi
- **Return**: View dengan semua lokasi dan studios mereka

### LocationController@search
- **Tujuan**: API endpoint untuk pencarian real-time
- **Parameter**: `search` (query string)
- **Return**: JSON response dengan lokasi yang cocok

### LocationController@show
- **Tujuan**: Menampilkan detail lengkap dari satu lokasi
- **Parameter**: Location model (via route model binding)
- **Return**: View dengan informasi lokasi, studios, dan fasilitas

### LocationController@getByCity
- **Tujuan**: Mendapatkan semua lokasi di satu kota
- **Parameter**: `city` (URL parameter)
- **Return**: JSON response

---

## Fitur-Fitur Halaman Pencarian Lokasi

### 1. **Search Box**
- Input field untuk mencari lokasi
- Real-time autocomplete suggestions
- Highlight hasil yang cocok dengan query
- Reset button untuk clear search

### 2. **Filter Tabs**
- **Semua Lokasi**: Tampilkan semua lokasi bioskop
- **Populer**: Tampilkan lokasi yang paling populer/sering dikunjungi
- **Terdekat**: Tampilkan lokasi berdasarkan geolokasi user

### 3. **Location Cards**
Setiap kartu menampilkan:
- Nama lokasi
- Kota
- Alamat
- Jumlah studio tersedia
- Daftar beberapa nama studio
- Tombol "Pilih Lokasi Ini"

### 4. **Loading State**
- Spinner animation saat memproses pilihan
- User feedback yang jelas

### 5. **Responsive Design**
- Mobile: 1 kolom
- Tablet: 2 kolom
- Desktop: 3 kolom

---

## Halaman Detail Lokasi (schedules.blade.php)

### Step Indicator
Progress bar menunjukkan:
1. ✓ Lokasi (completed)
2. Film & Jadwal (active)
3. Kursi (pending)
4. Pembayaran (pending)

### Fitur:
- **Breadcrumb Navigation**: Navigasi kembali ke pemilihan lokasi
- **Lokasi Info**: Nama dan detail lokasi yang dipilih, tombol ganti lokasi
- **Date Filter**: Pilih tanggal untuk melihat jadwal
- **Sidebar Filters**:
  - Genre filter
  - Rating filter
  - Waktu tayangan filter
- **Movie Cards**: Menampilkan film dengan:
  - Poster (placeholder)
  - Judul & Rating
  - Genre & Duration
  - Tombol jadwal untuk dipilih

---

## Model Relationships

```php
// Location has many Studios
Location → hasMany(Studio)
Studio → belongsTo(Location)

// Studio has many Schedules
Studio → hasMany(Schedule)
Schedule → belongsTo(Studio)
```

---

## Data Storage (localStorage)

### selectedLocation
```json
{
  "id": 1,
  "name": "XXI Cibinong",
  "selectedAt": "2024-05-08T10:30:00Z"
}
```

### selectedSchedule
```json
{
  "movieId": 1,
  "movieTitle": "Avengers",
  "time": "19:30",
  "studio": "Studio 1",
  "selectedAt": "2024-05-08T10:35:00Z"
}
```

---

## Integrasi dengan Aplikasi

### Untuk menambahkan link ke halaman pencarian lokasi:

```html
<!-- Di welcome page atau navbar -->
<a href="{{ route('locations.index') }}" class="btn btn-primary">
  <i class="fas fa-ticket-alt"></i> Pesan Tiket
</a>
```

### Untuk mengarahkan dari lokasi ke jadwal:

```php
// User klik tombol "Pilih Lokasi Ini"
// JavaScript akan menyimpan ke localStorage dan redirect ke:
window.location.href = `/location/{locationId}/schedules`;
```

---

## API Endpoints

### Search Lokasi
```
GET /locations/search?search=jakarta

Response:
[
  {
    "id": 1,
    "name": "XXI Cibinong",
    "city": "Bogor",
    "address": "Jl. Raya Cibinong",
    "studios": [...]
  },
  ...
]
```

### Lokasi by City
```
GET /locations/city/Jakarta

Response: Same as above
```

---

## Styling & UI

### Color Scheme
- **Primary**: Red (#EF4444)
- **Background**: Light Gray (#F3F4F6)
- **Text**: Dark Gray (#111827)
- **Cards**: White with shadow

### Icons (Font Awesome)
- `fas fa-map-marker-alt` - Lokasi
- `fas fa-building` - Studio
- `fas fa-star` - Rating
- `fas fa-film` - Film
- `fas fa-search` - Pencarian
- `fas fa-ticket-alt` - Tiket

---

## Cara Menggunakan

### 1. Akses Halaman Pencarian
```
URL: /locations
```

### 2. Cari Lokasi
- Ketik nama lokasi, kota, atau alamat di search box
- Hasil akan muncul secara real-time
- Klik pada salah satu hasil untuk memilihnya

### 3. Filter Lokasi (Optional)
- Klik tab "Populer" untuk melihat bioskop populer
- Klik tab "Terdekat" untuk melihat bioskop terdekat dengan lokasi Anda

### 4. Pilih Lokasi
- Klik tombol "Pilih Lokasi Ini" pada kartu lokasi
- Sistem akan menampilkan loading spinner
- Anda akan diarahkan ke halaman pemilihan film & jadwal

### 5. Pilih Film & Jadwal
- Pilih tanggal yang diinginkan
- Gunakan filter untuk menyaring film
- Klik tombol jadwal untuk melanjutkan ke pemilihan kursi

---

## Testing

### Manual Testing Checklist
- [ ] Search functionality bekerja dengan benar
- [ ] Filter tabs mengubah tampilan lokasi
- [ ] Card hover effect berfungsi
- [ ] Responsive design di berbagai ukuran layar
- [ ] LocalStorage menyimpan data dengan benar
- [ ] Navigation ke schedules page berfungsi
- [ ] Breadcrumb navigation bekerja
- [ ] Loading spinner ditampilkan

---

## Future Enhancements

1. **Geolocation**: Integrasi GPS untuk "Terdekat"
2. **Rating System**: Tampilkan rating untuk setiap lokasi
3. **Promo**: Tampilkan promo spesial per lokasi
4. **Favorites**: User bisa menyimpan lokasi favorit
5. **Reviews**: Tampilkan review dari pengguna lain
6. **Availability**: Real-time seat availability per jadwal

---

## Troubleshooting

### Search tidak menampilkan hasil
- Pastikan model Location sudah ada di database
- Check apakah data sudah di-seed
- Buka browser console untuk cek error

### Tidak bisa redirect ke schedules page
- Pastikan route sudah didefinisikan di routes/web.php
- Check localStorage apakah selectedLocation tersimpan
- Pastikan location ID valid

### UI tidak sesuai
- Clear browser cache (Ctrl+Shift+Delete)
- Pastikan Tailwind CSS sudah dikompile
- Check apakah CDN Font Awesome terakses

---

## Lisensi & Catatan

Fitur ini mengikuti pattern dari aplikasi XXI Cinema Indonesia dan dioptimasi untuk user experience yang baik.

Last Updated: May 8, 2026
