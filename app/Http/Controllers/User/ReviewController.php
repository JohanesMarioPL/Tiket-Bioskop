<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Movie;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id() ?? 1;
        $movie = Movie::first();
        $reviews = Review::where('movie_id', $movie->id)->latest()->get();
        
        return view('user-page.reviews.index', compact('reviews', 'movie'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:1000',
        ]);
        $userId = Auth::id() ?? 1;
        // $hasWatched = Transaction::where('user_id', $userId)->where('status', 'success')->whereHas('tickets.schedule', function ($query) use ($request) {$query->where('movie_id', $request->movie_id);})->exists();

        // if (!$hasWatched) {
        //     return back()->with('error', 'Kamu tidak bisa memberikan ulasan karena belum pernah membeli tiket film ini.');
        // }

        // $existingReview = Review::where('user_id', $userId)->where('movie_id', $request->movie_id)->first();
        // if ($existingReview) {
        //     return back()->with('error', 'Kamu sudah memberikan ulasan untuk film ini.');
        // }

        Review::create([
            'user_id'  => $userId,
            'movie_id' => $request->movie_id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasanmu berhasil dikirim.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
