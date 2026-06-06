<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Studio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::with(['movie', 'studio.location'])->orderBy('start_time', 'desc');
        if ($request->filled('date')) {
            $query->whereDate('start_time', $request->date);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('movie', function ($q2) use ($search) {
                    $q2->where('title', 'like', "%{$search}%");
                })->orWhereHas('studio', function ($q2) use ($search) {
                    $q2->where('studio_name', 'like', "%{$search}%");
                });
            });
        }
        $schedules = $query->paginate(10);
        return view('admin-dashboard.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::all();
        $studios = Studio::all();
        return view('admin-dashboard.schedules.create', compact('movies', 'studios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'studio_id'  => 'required|exists:studios,id',
            'start_time' => 'required|date|after:now',
            'base_price' => 'required|numeric|min:20000',
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        $newStartTime = Carbon::parse($request->start_time);
        $jedaWaktu = 30; 
        $newEndTime = $newStartTime->copy()->addMinutes($movie->duration_minutes + $jedaWaktu);
        $existingSchedules = Schedule::where('studio_id', $request->studio_id)
            ->whereDate('start_time', $newStartTime->toDateString())
            ->with('movie') 
            ->get();

        foreach ($existingSchedules as $schedule) {
            $existingStart = Carbon::parse($schedule->start_time);
            $existingEnd = $existingStart->copy()->addMinutes($schedule->movie->duration_minutes + $jedaWaktu);
            if ($newStartTime < $existingEnd && $newEndTime > $existingStart) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan jadwal! Jadwal bentrok dengan film "' . $schedule->movie->title . '" yang tayang dari jam ' . $existingStart->format('H:i') . ' s/d ' . $existingEnd->format('H:i'));
            }
        }

        Schedule::create([
            'movie_id'   => $request->movie_id,
            'studio_id'  => $request->studio_id,
            'start_time' => $newStartTime,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('admin.showtimes.index')
            ->with('success', 'Jadwal penayangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $movies = Movie::all();
        $studios = Studio::all();
        return view('admin-dashboard.schedules.edit', compact('schedule', 'movies', 'studios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'studio_id'  => 'required|exists:studios,id',
            'start_time' => 'required|date|after:now',
            'base_price' => 'required|numeric|min:20000',
        ]);

        $schedule = Schedule::findOrFail($id);
        $movie = Movie::findOrFail($request->movie_id);
        $newStartTime = Carbon::parse($request->start_time);
        $jedaWaktu = 30; 
        $newEndTime = $newStartTime->copy()->addMinutes($movie->duration_minutes + $jedaWaktu);

        $existingSchedules = Schedule::where('studio_id', $request->studio_id)
            ->where('id', '!=', $id)
            ->whereDate('start_time', $newStartTime->toDateString())
            ->with('movie')
            ->get();

        foreach ($existingSchedules as $existing) {
            $existingStart = Carbon::parse($existing->start_time);
            $existingEnd = $existingStart->copy()->addMinutes($existing->movie->duration_minutes + $jedaWaktu);
            if ($newStartTime < $existingEnd && $newEndTime > $existingStart) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal update! Jadwal bentrok dengan film "' . $existing->movie->title . '" yang tayang dari jam ' . $existingStart->format('H:i') . ' s/d ' . $existingEnd->format('H:i') . ' WIB.');
            }
        }

        $schedule->update([
            'movie_id'   => $request->movie_id,
            'studio_id'  => $request->studio_id,
            'start_time' => $newStartTime,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('admin.showtimes.index')
            ->with('success', 'Jadwal tayang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $ticketCount = $schedule->tickets()->count();

        if ($ticketCount > 0) {
            return back()->with('error', 'Jadwal tayang tidak bisa dihapus karena sudah ada ' . $ticketCount . ' tiket yang terjual.');
        }

        $schedule->delete();

        return redirect()->route('admin.showtimes.index')
            ->with('success', 'Jadwal tayang berhasil dihapus dari sistem.');
    }
}
