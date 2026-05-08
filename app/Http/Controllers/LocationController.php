<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Studio;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Tampilkan halaman pencarian lokasi bioskop
     */
    public function index()
    {
        $locations = Location::with('studios')->get();
        return view('locations.index', compact('locations'));
    }

    /**
     * Cari lokasi berdasarkan query atau filter
     */
    public function search(Request $request)
    {
        $query = $request->input('search', '');
        
        $locations = Location::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('city', 'like', "%{$query}%")
                  ->orWhere('address', 'like', "%{$query}%");
            })
            ->with('studios')
            ->get();

        return response()->json($locations);
    }

    /**
     * Tampilkan detail lokasi dengan studios
     */
    public function show(Location $location)
    {
        $location->load('studios.schedules');
        return view('locations.show', compact('location'));
    }

    /**
     * Dapatkan lokasi berdasarkan kota
     */
    public function getByCity($city)
    {
        $locations = Location::where('city', 'like', "%{$city}%")
            ->with('studios')
            ->get();

        return response()->json($locations);
    }
}
