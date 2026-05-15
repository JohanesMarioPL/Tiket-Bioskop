<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Movie;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('genre', 'like', '%' . $request->search . '%');
        }

        $movies = $query->latest()->paginate(10);

        return view('admin-dashboard.movie-management.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-dashboard.movie-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'rating_age' => 'required|string|in:SU,13+,17+,21+',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'title.required' => 'Judul film wajib diisi.',
            'genre.required' => 'Genre film wajib diisi.',
            'duration_minutes.required' => 'Durasi film wajib diisi.',
            'duration_minutes.integer' => 'Durasi harus berupa angka menit.',
            'rating_age.required' => 'Rating usia wajib dipilih.',
            'poster_url.image' => 'File poster harus berupa gambar.',
            'poster_url.mimes' => 'Format gambar yang diperbolehkan hanya JPEG, PNG, JPG, dan WEBP.',
            'poster_url.max' => 'Ukuran gambar poster tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('poster_url')) {
            $path = $request->file('poster_url')->store('posters', 'public');
            
            $validatedData['poster_url'] = $path;
        }

        Movie::create($validatedData);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Film "' . $request->title . '" berhasil ditambahkan ke daftar tayang!');
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
        $movie = Movie::findOrFail($id);
        return view('admin-dashboard.movie-management.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'rating_age' => 'required|string|in:SU,13+,17+,21+',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ], [
            'title.required' => 'Judul film wajib diisi.',
            'genre.required' => 'Genre film wajib diisi.',
            'duration_minutes.required' => 'Durasi film wajib diisi.',
            'duration_minutes.integer' => 'Durasi harus berupa angka menit.',
            'rating_age.required' => 'Rating usia wajib dipilih.',
            'poster_url.image' => 'File poster harus berupa gambar.',
            'poster_url.mimes' => 'Format gambar yang diperbolehkan hanya JPEG, PNG, JPG, dan WEBP.',
            'poster_url.max' => 'Ukuran gambar poster tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('poster_url')) {
            if ($movie->poster_url && Storage::disk('public')->exists($movie->poster_url)) {
                Storage::disk('public')->delete($movie->poster_url);
            }

            $path = $request->file('poster_url')->store('posters', 'public');
            
            $validatedData['poster_url'] = $path;
        } else {
            unset($validatedData['poster_url']);
        }

        $movie->update($validatedData);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Data film "' . $movie->title . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if ($movie->poster_url && Storage::disk('public')->exists($movie->poster_url)) {
            Storage::disk('public')->delete($movie->poster_url);
        }

        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Film "' . $movie->title . '" berhasil dihapus secara permanen!');
    }
}
