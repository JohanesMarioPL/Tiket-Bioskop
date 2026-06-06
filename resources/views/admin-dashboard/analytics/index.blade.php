@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6 w-full pb-8">
    <div>
        <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2">
            Film Terlaris
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($topMovies as $index => $movie)
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 flex gap-4 hover:-translate-y-1 transition-transform relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#faf3e0] text-yellow-900 font-black text-[10px] px-2.5 py-0.5 rounded-bl-lg">
                        #{{ $index + 1 }}
                    </div>
                    
                    <div class="w-16 h-24 bg-slate-200 rounded-md flex-shrink-0 overflow-hidden shadow-inner">
                        <img src="{{ $movie->poster_url }}" alt="Poster" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="flex flex-col justify-center">
                        <h3 class="font-bold text-slate-800 text-sm leading-snug mb-1 pr-4">{{ $movie->title }}</h3>
                        <p class="text-[10px] text-slate-500 mb-0.5">Pendapatan:</p>
                        <p class="text-xs font-bold text-green-600 mb-1.5">Rp {{ number_format($movie->total_pendapatan, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-semibold text-slate-700 bg-slate-100 w-max px-1.5 py-0.5 rounded">{{ number_format($movie->total_tiket_terjual, 0, ',', '.') }} Tiket Terjual</p>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-6 text-slate-500 bg-white rounded-xl">Belum ada data film terlaris.</div>
            @endforelse
        </div>
    </div>

    <h2 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2">
        Ringkasan Penjualan
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <p class="text-xs font-medium text-slate-500 mb-1">Total Pendapatan</p>
            <h3 class="text-xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <p class="text-xs font-medium text-slate-500 mb-1">Total Tiket Terjual</p>
            <h3 class="text-xl font-bold text-slate-800">{{ number_format($totalTiketTerjual, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">Pcs</span></h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <p class="text-xs font-medium text-slate-500 mb-1">Total Transaksi Sukses</p>
            <h3 class="text-xl font-bold text-slate-800">{{ number_format($transaksiSukses, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">Order</span></h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <p class="text-xs font-medium text-slate-500 mb-1">Pengguna Aktif</p>
            <h3 class="text-xl font-bold text-black">{{ number_format($pelanggan, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">Akun</span></h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Laporan Penjualan</h2>
                <p class="text-xs text-slate-500">Filter data untuk grafik dan performa film.</p>
            </div>
            
            <a href="{{ route('admin.analytics.export', request()->all()) }}" class="flex items-center justify-center gap-2 bg-[#4b3936] hover:bg-[#3b2c29] text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm self-stretch sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Export PDF
            </a>
        </div>

        <form id="filterForm" action="{{ route('admin.analytics.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <div class="flex flex-wrap gap-1 p-1 bg-slate-100 rounded-xl w-max">
                <button type="button" onclick="setQuickDate('today')" class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ request('start_date') === date('Y-m-d') && request('end_date') === date('Y-m-d') ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }}">
                    Hari Ini
                </button>
                @php
                    $startOfMonth = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
                    $endOfMonth = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
                    $isThisMonth = request('start_date') === $startOfMonth && request('end_date') === $endOfMonth;
                @endphp
                <button type="button" onclick="setQuickDate('this_month')" class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $isThisMonth ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }}">
                    Bulan Ini
                </button>
                @php
                    $startOfYear = \Carbon\Carbon::now()->startOfYear()->format('Y-m-d');
                    $endOfYear = \Carbon\Carbon::now()->endOfYear()->format('Y-m-d');
                    $isThisYear = request('start_date') === $startOfYear && request('end_date') === $endOfYear;
                @endphp
                <button type="button" onclick="setQuickDate('this_year')" class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $isThisYear ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }}">
                    Tahun Ini
                </button>
                <a href="{{ route('admin.analytics.index') }}" class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ !request('start_date') && !request('end_date') ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/40' }} text-center">
                    Semua Waktu
                </a>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex bg-slate-50 rounded-lg p-1 border border-slate-200 items-center">
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="bg-transparent text-sm border-none focus:ring-0 text-slate-700 p-1 w-[130px] outline-none">
                    <span class="text-slate-400 mx-1">-</span>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="bg-transparent text-sm border-none focus:ring-0 text-slate-700 p-1 w-[130px] outline-none">
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" class="bg-[#344152] hover:bg-[#475569] text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                        Terapkan
                    </button>

                    @if(request()->has('start_date') || request()->has('end_date'))
                        <a href="{{ route('admin.analytics.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="mb-8">
            <h3 class="font-bold text-sm text-slate-700 mb-3">Grafik Penjualan Harian</h3>
            <div id="salesChart" class="w-full h-[260px]"></div>
        </div>

        <div>
            <h3 class="font-bold text-sm text-slate-700 mb-3">Detail Performa Seluruh Film</h3>
            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="min-w-full divide-y divide-slate-200 text-xs">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2.5 text-left font-bold text-slate-500 uppercase tracking-wider">Peringkat</th>
                            <th class="px-4 py-2.5 text-left font-bold text-slate-500 uppercase tracking-wider">Judul Film</th>
                            <th class="px-4 py-2.5 text-center font-bold text-slate-500 uppercase tracking-wider">Tiket Terjual</th>
                            <th class="px-4 py-2.5 text-right font-bold text-slate-500 uppercase tracking-wider">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($allMoviePerformance as $index => $movie)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-slate-500 font-bold">#{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $movie->title }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="bg-[#cbdfea]/30 text-[#344152] px-2.5 py-0.5 rounded-full font-bold">
                                        {{ number_format($movie->total_tiket_terjual, 0, ',', '.') }} Pcs
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap font-bold text-green-600 text-right">
                                    Rp {{ number_format($movie->total_pendapatan, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-slate-500">Tidak ada data penjualan pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function setQuickDate(period) {
        const today = new Date();
        const startInput = document.getElementById('start_date');
        const endInput = document.getElementById('end_date');
        
        const formatDate = (date) => {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        };

        let startDate, endDate;

        if (period === 'today') {
            startDate = formatDate(today);
            endDate = startDate;
        } else if (period === 'this_month') {
            startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
            endDate = formatDate(new Date(today.getFullYear(), today.getMonth() + 1, 0));
        } else if (period === 'this_year') {
            startDate = formatDate(new Date(today.getFullYear(), 0, 1));
            endDate = formatDate(new Date(today.getFullYear(), 11, 31));
        }

        startInput.value = startDate;
        endInput.value = endDate;
        document.getElementById('filterForm').submit();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const dates = {!! json_encode($dailySales->pluck('date')->map(function($date) { return \Carbon\Carbon::parse($date)->format('d M'); })) !!};
        const revenues = {!! json_encode($dailySales->pluck('revenue')) !!};

        const options = {
            series: [{ name: 'Pendapatan Harian', data: revenues }],
            chart: { type: 'area', height: 260, toolbar: { show: false }, fontFamily: 'inherit' },
            colors: ['#4B3935'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.0, stops: [0, 100] }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: { categories: dates },
            yaxis: {
                labels: {
                    formatter: function (value) { return "Rp " + (value / 1000).toFixed(0) + "K"; }
                }
            },
            tooltip: { theme: 'light' }
        };

        if (dates.length > 0) {
            new ApexCharts(document.querySelector("#salesChart"), options).render();
        } else {
            document.querySelector("#salesChart").innerHTML = '<div class="flex items-center justify-center h-full text-slate-400">Belum ada data grafik yang cukup.</div>';
        }
    });
</script>
@endsection