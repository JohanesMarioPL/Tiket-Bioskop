<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Schedule;
use Carbon\Carbon;

class CinemaController extends Controller
{
    /**
     * Menampilkan daftar bioskop berdasarkan Kota dan Pencarian (Seperti gambar pertama)
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kota yang tersedia di database untuk dropdown Navbar
        $cities = Location::select('city')->distinct()->pluck('city');
        
        // 2. Tentukan kota yang sedang dipilih (Default 'Bandung' jika baru pertama buka)
        $selectedCity = $request->input('city', $cities->first() ?? 'Bandung');
        
        // 3. Mulai query pencarian Lokasi (Bioskop) berdasarkan kota
        $query = Location::where('city', $selectedCity);
        
        // 4. Jika ada input pencarian text (nama bioskop / alamat)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // 5. Eksekusi query, kita panggil juga relasi 'studios' untuk tahu 
        // apakah bioskop ini punya "Cinema XXI", "The Premiere", dll.
        $cinemas = $query->with('studios')->get();
        
        // Kirim data ke view (nanti kita buat di tahap selanjutnya)
        return view('cinemas.index', compact('cities', 'selectedCity', 'cinemas'));
    }

    /**
     * Menampilkan detail bioskop beserta jadwal film (Seperti gambar kedua)
     */
    public function show(Request $request, $id)
    {
        // 1. Cari data Bioskop (Location)
        $cinema = Location::findOrFail($id);
        
        // 2. Generate daftar 7 hari ke depan untuk tab pilihan tanggal
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Carbon::today()->addDays($i);
        }
        
        // 3. Tentukan tanggal yang sedang dilihat jadwalnya (Default: Hari ini)
        $selectedDate = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        // 4. Ambil jadwal (Schedule) HANYA untuk bioskop ini dan pada tanggal terpilih
        $schedules = Schedule::whereDate('start_time', $selectedDate)
            ->whereHas('studio', function($q) use ($id) {
                $q->where('location_id', $id); // Filter berdasarkan ID Lokasi Bioskop
            })
            ->with(['movie', 'studio']) // Eager loading relasi agar tidak query N+1
            ->orderBy('start_time', 'asc')
            ->get();
            
        // 5. Kelompokkan jadwal agar mudah di-render di HTML
        // Berdasarkan gambar 2, urutannya: Tipe Studio -> Daftar Film -> Jam Tayang
        $groupedSchedules = [];
        foreach ($schedules as $schedule) {
            $studioType = $schedule->studio->studio_type; // cth: 'Reguler' atau 'Premiere'
            $movieId = $schedule->movie_id;
            
            // Jika belum ada array untuk tipe studio dan film ini, buat format dasarnya
            if (!isset($groupedSchedules[$studioType][$movieId])) {
                $groupedSchedules[$studioType][$movieId] = [
                    'movie' => $schedule->movie,
                    'schedules' => []
                ];
            }
            
            // Masukkan jadwal jam tayang ke dalam kelompoknya
            $groupedSchedules[$studioType][$movieId]['schedules'][] = $schedule;
        }
        
        // Kirim data ke view
        return view('cinemas.show', compact('cinema', 'dates', 'selectedDate', 'groupedSchedules'));
    }
}