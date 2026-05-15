<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Location::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('city', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%');
        }

        $locations = $query->latest()->paginate(10);

        return view('admin-dashboard.location-management.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-dashboard.location-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
        ], [
            'name.required' => 'Nama lokasi/bioskop wajib diisi.',
            'city.required' => 'Nama kota wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
        ]);

        Location::create($validatedData);

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Lokasi "' . $request->name . '" berhasil ditambahkan!');
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
        $location = Location::findOrFail($id);
        return view('admin-dashboard.location-management.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
        ], [
            'name.required' => 'Nama lokasi/bioskop wajib diisi.',
            'city.required' => 'Nama kota wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
        ]);

        $location->update($validatedData);

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Data lokasi "' . $location->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Lokasi "' . $location->name . '" berhasil dihapus secara permanen!');
    }
}
