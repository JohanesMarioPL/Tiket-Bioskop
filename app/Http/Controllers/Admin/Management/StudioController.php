<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Studio;
use App\Models\Location;
use App\Models\Seat;
use App\DesignPatterns\StudioFactory\Factories\RegularStudioFactory;
use App\DesignPatterns\StudioFactory\Factories\PremiereStudioFactory;
use App\DesignPatterns\StudioFactory\Factories\ImaxStudioFactory;
use App\DesignPatterns\StudioFactory\Factories\StariumStudioFactory;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locations = Location::all();
        $query = Studio::with(['location', 'seats'])->withCount('seats')->orderBy('created_at', 'desc');
        if ($request->filled('location')) {
            $query->where('location_id', $request->location);
        }
        if ($request->filled('search')) {
            $query->where('studio_name', 'like', "%{$request->search}%");
        }

        $studios = $query->paginate(10);
        return view('admin-dashboard.studio.index', compact('studios', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('admin-dashboard.studio.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'studio_name' => 'required|string|max:255',
            'studio_type' => 'required|in:Regular,Premiere,IMAX,Starium',
            'capacity'    => 'required|integer|min:10',
        ]);

        $studio = Studio::create([
            'location_id' => $request->location_id,
            'studio_name' => $request->studio_name,
            'studio_type' => $request->studio_type,
            'capacity'    => $request->capacity
        ]);

        $type = $request->studio_type;
        $factory = match(true) {
            str_contains($type, 'IMAX') => new ImaxStudioFactory(),
            str_contains($type, 'Premiere') => new PremiereStudioFactory(),
            str_contains($type, 'Starium')  => new StariumStudioFactory(),
            default => new RegularStudioFactory(),
        };
        $seatProduct = $factory->createSeat();
        $seatLayouts = $seatProduct->generateLayout($studio->capacity);
        $seatData = [];
        $now = now();
        foreach ($seatLayouts as $seatNumber) {
            $seatData[] = [
                'studio_id'   => $studio->id,
                'seat_number' => $seatNumber,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }
        Seat::insert($seatData); 
        return redirect()->route('admin.studio.index')
            ->with('success', "Studio {$request->studio_type} berhasil dibuat");
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
    public function edit(string $id)
    {
        $studio = Studio::findOrFail($id);
        $locations = Location::all();
        return view('admin-dashboard.studio.edit', compact('studio', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'studio_name' => 'required|string|max:255',
        ]);
        $studio = Studio::findOrFail($id);
        $studio->update([
            'location_id' => $request->location_id,
            'studio_name' => $request->studio_name,
        ]);
        return redirect()->route('admin.studio.index')
            ->with('success', 'Data Studio berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $studio = Studio::findOrFail($id);
        $scheduleCount = $studio->schedules()->count();
        if ($scheduleCount > 0) {
            return back()->with('error', 'Gagal! Studio tidak bisa dihapus karena masih digunakan pada ' . $scheduleCount . ' jadwal tayang. Hapus jadwal tayangnya terlebih dahulu.');
        }
        $studio->delete();
        return redirect()->route('admin.studio.index')
            ->with('success', 'Studio dan data kursinya berhasil dihapus.');
    }
}
