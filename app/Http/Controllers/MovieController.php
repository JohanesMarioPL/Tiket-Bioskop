<?php

namespace App\Http\Controllers;

use App\Models\Movie;
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
}
