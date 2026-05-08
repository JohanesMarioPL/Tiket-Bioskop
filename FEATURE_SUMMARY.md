# 📍 FITUR PENCARIAN LOKASI BIOSKOP - RINGKASAN LENGKAP

## 🎬 Overview

Fitur pencarian lokasi bioskop adalah halaman entry point untuk proses pemesanan tiket bioskop online. Fitur ini mengikuti pattern dari aplikasi XXI Cinema Indonesia, di mana user harus memilih lokasi terlebih dahulu sebelum memilih film dan jadwal.

---

## 🔄 User Flow

```
┌─────────────────────────────┐
│   Buka Website / Home Page  │
└──────────────┬──────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│  HALAMAN PENCARIAN LOKASI (/locations)  │ ← File: index.blade.php
│  - Lihat daftar semua lokasi             │
│  - Search by nama/kota/alamat            │
│  - Filter: Semua / Populer / Terdekat    │
│  - Hover card untuk preview lokasi       │
└──────────────┬──────────────────────────┘
               │
       Klik "Pilih Lokasi"
               │
               ▼
┌──────────────────────────────────────────────┐
│ HALAMAN PEMILIHAN FILM & JADWAL              │ ← File: schedules.blade.php
│ (/location/{id}/schedules)                   │
│ - Tampilkan lokasi yang dipilih              │
│ - Filter tanggal                             │
│ - Filter genre / rating / waktu              │
│ - Daftar film dengan jadwal                  │
└──────────────┬───────────────────────────────┘
               │
       Klik "Pilih Jadwal"
               │
               ▼
    ┌─────────────────────────┐
    │ Halaman Pemilihan Kursi │ (Future)
    └─────────────────────────┘
```

---

## 📁 File Structure Created

### Controllers
```
app/Http/Controllers/LocationController.php
├── index()           → GET /locations (show search page)
├── search()          → GET /locations/search?search=... (JSON API)
├── show()            → GET /locations/{id} (show detail)
└── getByCity()       → GET /locations/city/{city} (JSON API)
```

### Views
```
resources/views/locations/
├── index.blade.php       → Halaman utama pencarian lokasi
├── show.blade.php        → Halaman detail lokasi
└── schedules.blade.php   → Halaman pemilihan film & jadwal
```

### Seeders
```
database/seeders/LocationSeeder.php  → Generate sample data
```

### Routes
```
routes/web.php
├── GET  /locations              → LocationController@index
├── GET  /locations/search       → LocationController@search
├── GET  /locations/{location}   → LocationController@show
├── GET  /locations/city/{city}  → LocationController@getByCity
└── GET  /location/{id}/schedules → Inline closure (schedules page)
```

---

## 🎨 Halaman 1: Pencarian Lokasi

### Components
1. **Header**
   - Judul: "Pilih Lokasi Bioskop"
   - Subtitle: "Temukan bioskop terdekat dengan lokasi Anda"
   - Breadcrumb (jika dari halaman lain)

2. **Search Section**
   - Input field dengan icon search
   - Real-time autocomplete
   - Reset button
   - Suggestions dropdown

3. **Filter Tabs**
   - Semua Lokasi
   - Populer
   - Terdekat (geolocation)

4. **Location Cards Grid**
   - Responsive: 1 col (mobile) → 2 cols (tablet) → 3 cols (desktop)
   - Setiap card menampilkan:
     - Banner dengan gradient red
     - Nama lokasi
     - Kota & alamat
     - Jumlah studio
     - Daftar studio (preview)
     - Tombol "Pilih Lokasi Ini"

5. **Footer/Loading State**
   - Loading spinner saat processing

### Teknologi
- **Framework**: Laravel Blade
- **Styling**: Tailwind CSS
- **Icons**: Font Awesome
- **Interactivity**: Vanilla JavaScript
- **Storage**: Browser localStorage

---

## 🎬 Halaman 2: Pemilihan Film & Jadwal

### Components
1. **Header dengan Breadcrumb**
   - Lokasi (completed ✓)
   - Film & Jadwal (active)
   - Kursi (pending)
   - Pembayaran (pending)

2. **Lokasi Info Card**
   - Nama lokasi yang dipilih
   - Detail lokasi
   - Tombol "Ganti Lokasi"

3. **Date Filter Section**
   - 4 quick date buttons (Today, Tomorrow, 3 Days, Week)
   - Calendar date picker (optional)

4. **Sidebar Filters**
   - Genre checkboxes
   - Rating radio buttons
   - Waktu tayangan checkboxes
   - Apply/Reset buttons

5. **Movies List**
   - Movie card layout dengan:
     - Poster (placeholder)
     - Judul & rating
     - Genre & durasi
     - Jadwal buttons (time & studio)
   - Klik jadwal untuk pilih

### Data Flow
```
User Picks Location
    ↓
localStorage.setItem('selectedLocation')
    ↓
Redirect to /location/{id}/schedules
    ↓
Load movies for that location
    ↓
User Picks Schedule
    ↓
localStorage.setItem('selectedSchedule')
    ↓
Redirect to next step (seats selection)
```

---

## 🗄️ Database Schema

### locations table
```sql
CREATE TABLE locations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### studios table
```sql
CREATE TABLE studios (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    location_id BIGINT UNSIGNED NOT NULL,
    studio_name VARCHAR(255) NOT NULL,
    studio_type VARCHAR(255) NOT NULL,      -- 2D/3D/4DX/IMAX
    capacity INT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE
);
```

### Sample Data
```
Locations:
- XXI Cibinong (Bogor)
- XXI Sentosa (Jakarta)
- XXI Kelapa Gading (Jakarta)
- XXI Bandung (Bandung)
- XXI Lippo Karawaci (Tangerang)
- XXI Blitz Megaplex (Jakarta)
- CGV Grand Indonesia (Jakarta)
- Cinemaxx Indonesia (Jakarta)

Each location has 2-5 studios with different types
```

---

## 💾 Local Storage Usage

### selectedLocation
Disimpan ketika user memilih lokasi
```javascript
{
    id: 1,
    name: "XXI Cibinong",
    selectedAt: "2024-05-08T10:30:00Z"
}
```

### selectedSchedule
Disimpan ketika user memilih jadwal
```javascript
{
    movieId: 1,
    movieTitle: "Avengers",
    time: "19:30",
    studio: "Studio 1",
    selectedAt: "2024-05-08T10:35:00Z"
}
```

---

## 🚀 Cara Menjalankan

### 1. Setup Database
```bash
# Run migrations
php artisan migrate

# Seed sample data
php artisan db:seed --class=LocationSeeder
```

### 2. Build Assets
```bash
npm run dev
```

### 3. Start Server
```bash
php artisan serve
```

### 4. Akses Fitur
Buka browser: **http://localhost:8000/locations**

---

## 🎯 Features Checklist

### Halaman Pencarian Lokasi
- [x] Display semua lokasi dalam grid
- [x] Search functionality dengan autocomplete
- [x] Filter tabs (Semua/Populer/Terdekat)
- [x] Location cards dengan info lengkap
- [x] Responsive design (mobile/tablet/desktop)
- [x] Loading spinner saat processing
- [x] LocalStorage untuk store pilihan

### Halaman Film & Jadwal
- [x] Breadcrumb navigation
- [x] Step indicator (1/4)
- [x] Tampilkan lokasi yang dipilih
- [x] Date filter buttons
- [x] Genre filter
- [x] Rating filter
- [x] Waktu tayangan filter
- [x] Movie cards dengan jadwal
- [x] Tombol untuk pilih jadwal
- [x] Responsive sidebar

---

## 🎨 UI/UX Highlights

### Colors
- **Primary**: Red (#EF4444)
- **Background**: Light Gray (#F3F4F6)
- **Text**: Dark Gray (#111827)
- **Cards**: White with subtle shadow

### Typography
- **Headings**: Bold, large font
- **Body**: Regular, readable size
- **Links**: Red with underline

### Spacing
- **Sections**: 2rem gap
- **Cards**: 1.5rem gap
- **Padding**: 1.5rem - 2rem

### Interactions
- **Hover**: Card elevation (translateY -5px)
- **Click**: Button color change
- **Loading**: Spinning animation
- **Transitions**: Smooth 0.3s ease

---

## 📱 Responsive Breakpoints

### Mobile (< 768px)
- 1 column grid
- Full-width inputs
- Stacked layout

### Tablet (768px - 1024px)
- 2 column grid
- Side-by-side layout
- Adjusted padding

### Desktop (> 1024px)
- 3 column grid
- Sidebar layout
- Full feature set

---

## 🔐 Validation & Error Handling

### Frontend
- Non-empty search validation
- Valid location selection
- Prevent duplicate API calls

### Backend
- Model validation
- Null/empty check
- Foreign key constraints
- Error response with HTTP status

---

## 🧪 Testing Scenarios

### Scenario 1: Search Lokasi Jakarta
1. Akses /locations
2. Type "Jakarta" di search
3. Verify: Hanya lokasi Jakarta yang muncul
4. Klik salah satu lokasi
5. Verify: Redirect ke schedules page

### Scenario 2: Filter Terdekat
1. Akses /locations
2. Click "Terdekat" tab
3. Verify: Lokasi diurutkan berdasarkan jarak (simulated)

### Scenario 3: Mobile Experience
1. Open /locations di mobile browser
2. Verify: 1 column grid
3. Verify: Search dropdown teratasi
4. Verify: Tap action responsive

---

## 🔄 Integration Points

### Dengan Sistem Pemesanan Tiket
```
Pencarian Lokasi
    ↓
Pemilihan Film & Jadwal
    ↓
Pemilihan Kursi (TODO)
    ↓
Checkout & Pembayaran (TODO)
    ↓
Konfirmasi Tiket (TODO)
```

### API Endpoints untuk Integration
```
GET  /locations              # All locations
GET  /locations/search       # Search query
GET  /locations/{id}         # Location detail
GET  /locations/city/{city}  # By city
```

---

## 📊 Performance Considerations

### Optimizations
- ✅ Lazy loading images
- ✅ Minimal JavaScript bundle
- ✅ Efficient database queries
- ✅ Client-side caching (localStorage)
- ✅ CSS minification via Tailwind

### Future Improvements
- [ ] Add pagination for large datasets
- [ ] Implement caching headers
- [ ] Add database indexing
- [ ] Optimize image sizes

---

## 🚨 Known Limitations

1. **Geolocation**: "Terdekat" currently uses mock data
2. **Movies Data**: Sample movies hardcoded in view
3. **Schedule**: Mock schedules untuk demo
4. **Images**: Placeholder images dari API eksternal
5. **Real-time**: Tidak ada live seat updates

---

## 📈 Future Enhancements

### Phase 1 (Current)
- ✅ Location search & filter
- ✅ Movie & schedule display

### Phase 2 (Next)
- [ ] Seat selection page
- [ ] Payment integration
- [ ] Ticket confirmation

### Phase 3 (Later)
- [ ] User account & booking history
- [ ] Rating & reviews system
- [ ] Promo code system
- [ ] Push notifications

---

## 📞 Support & Documentation

Untuk informasi lebih lanjut:
- Baca: `LOCATION_FEATURE_DOCS.md` (dokumentasi detail)
- Baca: `SETUP_LOCATION_FEATURE.md` (setup instructions)
- Check: `resources/views/locations/` (view code)
- Check: `app/Http/Controllers/LocationController.php` (logic)

---

**Created**: May 8, 2026  
**Version**: 1.0.0  
**Status**: ✅ Ready for Development
