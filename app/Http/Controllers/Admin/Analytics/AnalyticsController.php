<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $hasDateFilter = $startDate && $endDate;
        $start = $hasDateFilter ? Carbon::parse($startDate)->startOfDay() : null;
        $end = $hasDateFilter ? Carbon::parse($endDate)->endOfDay() : null;

        $querySukses = Transaction::where('status', 'paid');
        if ($hasDateFilter) {
            $querySukses->whereBetween('created_at', [$start, $end]);
        }

        $totalRevenue = (clone $querySukses)->sum('total_amount');
        $transaksiSukses = (clone $querySukses)->count();
        
        $pelanggan = (clone $querySukses)->distinct('user_id')->count('user_id');

        $totalTiketTerjual = DB::table('tickets')
            ->join('transactions', 'tickets.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'paid')
            ->when($hasDateFilter, function($q) use ($start, $end) {
                return $q->whereBetween('transactions.created_at', [$start, $end]);
            })
            ->count();

        $chartQuery = (clone $querySukses)->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'ASC');

        if (!$hasDateFilter) {
            $latestTx = Transaction::where('status', 'paid')->latest()->first();
            if ($latestTx) {
                $latestDate = Carbon::parse($latestTx->created_at);
                $chartQuery->where('created_at', '>=', $latestDate->copy()->subDays(30));
            } else {
                $chartQuery->where('created_at', '>=', Carbon::now()->subDays(30));
            }
        }
        $dailySalesRaw = $chartQuery->get();

        if ($hasDateFilter) {
            $startDateObj = Carbon::parse($startDate);
            $endDateObj = Carbon::parse($endDate);
        } else {
            $latestTx = Transaction::where('status', 'paid')->latest()->first();
            if ($latestTx) {
                $endDateObj = Carbon::parse($latestTx->created_at);
                $startDateObj = $endDateObj->copy()->subDays(30);
            } else {
                $endDateObj = Carbon::now();
                $startDateObj = $endDateObj->copy()->subDays(30);
            }
        }

        if ($startDateObj->diffInDays($endDateObj) > 366) {
            $startDateObj = $endDateObj->copy()->subDays(366);
        }

        $salesMap = $dailySalesRaw->pluck('revenue', 'date')->toArray();
        $dailySales = collect();
        $currentDate = $startDateObj->copy();

        while ($currentDate->lte($endDateObj)) {
            $dateStr = $currentDate->format('Y-m-d');
            $revenue = $salesMap[$dateStr] ?? 0;
            
            $dailySales->push((object)[
                'date' => $dateStr,
                'revenue' => (float)$revenue
            ]);
            
            $currentDate->addDay();
        }

        $allMoviePerformance = Movie::query()
            ->select(
                'movies.id',
                'movies.title',
                'movies.poster_url',
                DB::raw('COUNT(tickets.id) as total_tiket_terjual'),
                DB::raw('COALESCE(SUM(tickets.final_price), 0) as total_pendapatan')
            )
            ->leftJoin('schedules', 'movies.id', '=', 'schedules.movie_id')
            ->leftJoin('tickets', 'schedules.id', '=', 'tickets.schedule_id')
            ->leftJoin('transactions', function ($join) use ($hasDateFilter, $start, $end) {
                $join->on('tickets.transaction_id', '=', 'transactions.id')
                     ->where('transactions.status', '=', 'paid');
                if ($hasDateFilter) {
                    $join->whereBetween('transactions.created_at', [$start, $end]);
                }
            })
            ->groupBy('movies.id', 'movies.title', 'movies.poster_url')
            ->orderByDesc('total_pendapatan')
            ->get();

        $topMovies = $allMoviePerformance->take(3);

        return view('admin-dashboard.analytics.index', compact(
            'totalRevenue', 'totalTiketTerjual', 'transaksiSukses', 
            'pelanggan', 'dailySales', 'allMoviePerformance', 'topMovies'
        ));
    }

    public function exportPDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $hasDateFilter = $startDate && $endDate;
        $start = $hasDateFilter ? Carbon::parse($startDate)->startOfDay() : null;
        $end = $hasDateFilter ? Carbon::parse($endDate)->endOfDay() : null;

        $querySukses = Transaction::with(['user', 'tickets'])->where('status', 'paid');
        
        if ($hasDateFilter) {
            $querySukses->whereBetween('created_at', [$start, $end]);
        }

        $transactions = $querySukses->latest()->get();

        $totalRevenue = $transactions->sum('total_amount');
        $transaksiSukses = $transactions->count();
        $pelangganUnik = $transactions->pluck('user_id')->unique()->count();

        $totalTiketTerjual = $transactions->sum(function($trx) {
            return $trx->tickets->count();
        });

        if (!$hasDateFilter) {
            $periodTitle = "Semua Waktu";
            $periodRange = "Keseluruhan Data Sampai Saat Ini";
            $fileNameDate = "All";
        } else {
            $periodTitle = "Kustom";
            $periodRange = Carbon::parse($startDate)->format('d M Y') . ' s/d ' . Carbon::parse($endDate)->format('d M Y');
            $fileNameDate = $startDate . '_to_' . $endDate;
        }

        $printDate = Carbon::now()->translatedFormat('l, d F Y');

        $pdf = Pdf::loadView('admin-dashboard.analytics.export-pdf', compact(
            'transactions', 'totalRevenue', 'totalTiketTerjual', 'transaksiSukses', 
            'pelangganUnik', 'periodTitle', 'periodRange', 'printDate'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Bioskop_' . $fileNameDate . '.pdf');
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
