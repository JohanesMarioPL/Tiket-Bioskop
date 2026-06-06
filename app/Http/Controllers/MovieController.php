<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $genre  = $request->input('genre');
        $rating = $request->input('rating');

        // Fetch unique genres and ratings for dropdowns
        $genres  = Movie::distinct()->pluck('genre')->sort();
        $ratings = Movie::distinct()->pluck('rating_age')->sort();

        $movies = Movie::query()
            ->search($search)
            ->filterGenre($genre)
            ->filterRating($rating)
            ->orderBy('title')
            ->get();

        return view('movies.index', compact('movies', 'search', 'genre', 'rating', 'genres', 'ratings'));
    }

    public function show(Movie $movie)
    {
        $schedules = Schedule::with(['studio.location'])
            ->where('movie_id', $movie->id)
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();

        $reviews = $movie->reviews()->with('user')->latest()->get();

        return view('movies.show', compact('movie', 'schedules', 'reviews'));
    }
}
