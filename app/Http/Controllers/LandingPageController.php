<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topMovies = Movie::select('movies.*', DB::raw('COALESCE(SUM(tickets.final_price), 0) as total_pendapatan'))->join('schedules', 'movies.id', '=', 'schedules.movie_id')->leftJoin('tickets', 'schedules.id', '=', 'tickets.schedule_id')->leftJoin('transactions', function ($join) {
            $join->on('tickets.transaction_id', '=', 'transactions.id')
                    ->where('transactions.status', '=', 'success');
        })->where('schedules.start_time', '>=', Carbon::now())->groupBy('movies.id', 'movies.title', 'movies.description', 'movies.genre', 'movies.duration_minutes', 'movies.rating_age', 'movies.poster_url', 'movies.created_at', 'movies.updated_at')->orderByDesc('total_pendapatan')->with(['schedules' => function($q) {$q->where('start_time', '>=', Carbon::now())->with('studio.location');}])->take(5)->get();

        $randomBanners = Movie::whereHas('schedules', function ($q) {
            $q->where('start_time', '>=', Carbon::now());
        })->with(['schedules' => function($q) {$q->where('start_time', '>=', Carbon::now());}])->inRandomOrder()->take(2)->get();
        
        $featuredMovies = Movie::whereHas('schedules', function ($q) {
            $q->where('start_time', '>=', Carbon::now());
        })->with(['schedules' => function($q) {
            $q->where('start_time', '>=', Carbon::now())->with('studio.location');
        }])->latest()->take(6)->get();

        return view('user-landing-page', compact('topMovies', 'randomBanners', 'featuredMovies'));
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
        //
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
