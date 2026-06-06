@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-8 w-full pb-10">
    <div>
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            Film Terlaris
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($topMovies as $index => $movie)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex gap-4 hover:-translate-y-1 transition-transform relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#faf3e0] text-yellow-900 font-black text-xs px-3 py-1 rounded-bl-xl">
                        #{{ $index + 1 }}
                    </div>
                    
                    <div class="w-20 h-28 bg-slate-200 rounded-lg flex-shrink-0 overflow-hidden shadow-inner">
                        @if($movie->poster_url)
                            <img src="{{ asset('storage/' . $movie->poster_url) }}" alt="Poster" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">No Image</div>
                        @endif
                    </div>
                    
                    <div class="flex flex-col justify-center">
                        <h3 class="font-bold text-slate-800 text-base leading-tight mb-2 pr-4">{{ $movie->title }}</h3>
                        <p class="text-xs text-slate-500 mb-0.5">Pendapatan:</p>
                        <p class="text-sm font-bold text-green-600 mb-2">Rp {{ number_format($movie->total_pendapatan, 0, ',', '.') }}</p>
                        <p class="text-xs font-semibold text-slate-700 bg-slate-100 w-max px-2 py-1 rounded-md">{{ number_format($movie->total_tiket_terjual, 0, ',', '.') }} Tiket Terjual</p>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-6 text-slate-500 bg-white rounded-2xl">Belum ada data film terlaris.</div>
            @endforelse
        </div>
    </div>

    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
        Ringkasan Penjualan
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Tiket Terjual</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalTiketTerjual, 0, ',', '.') }} <span class="text-sm font-normal text-slate-400">Pcs</span></h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Transaksi Sukses</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($transaksiSukses, 0, ',', '.') }} <span class="text-sm font-normal text-slate-400">Order</span></h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500 mb-1">Pengguna Aktif</p>
            <h3 class="text-2xl font-bold text-black">{{ number_format($pelanggan, 0, ',', '.') }} <span class="text-sm font-normal text-slate-400">Akun pernah bertransaksi</span></h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Laporan Penjualan</h2>
                <p class="text-sm text-slate-500">Filter data untuk grafik dan performa film.</p>
            </div>
            
            <form id="filterForm" action="{{ route('admin.analytics.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="flex gap-2">
                    <button type="button" onclick="setQuickDate('today')" class="px-3 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition">Hari Ini</button>
                    <button type="button" onclick="setQuickDate('this_month')" class="px-3 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition">Bulan Ini</button>
                    <button type="button" onclick="setQuickDate('this_year')" class="px-3 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition">Tahun Ini</button>
                    <a href="{{ route('admin.analytics.index') }}" class="px-3 py-1.5 text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition">Semua Waktu</a>
                </div>

                <div class="flex bg-slate-50 rounded-lg p-1 border border-slate-200 items-center">
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="bg-transparent text-sm border-none focus:ring-0 text-slate-700 p-1 w-[130px] outline-none">
                    <span class="text-slate-400 mx-1">-</span>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="bg-transparent text-sm border-none focus:ring-0 text-slate-700 p-1 w-[130px] outline-none">
                </div>
                
                <button type="submit" class="bg-[#344152] hover:bg-[#475569] text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                    Terapkan
                </button>

                @if(request()->has('start_date') || request()->has('end_date'))
                    <a href="{{ route('admin.analytics.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                        Reset
                    </a>
                @endif

                <a href="{{ route('admin.analytics.export', request()->all()) }}" class="flex items-center gap-2 bg-[#4b3936] hover:bg-[#3b2c29] text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Export PDF
                </a>
            </form>
        </div>

        <div class="mb-10">
            <h3 class="font-bold text-slate-700 mb-4">Grafik Penjualan Harian</h3>
            <div id="salesChart" class="w-full h-[300px]"></div>
        </div>

        <div>
            <h3 class="font-bold text-slate-700 mb-4">Detail Performa Seluruh Film</h3>
            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Film</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Tiket Terjual</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($allMoviePerformance as $index => $movie)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-bold">#{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $movie->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="bg-[#cbdfea]/30 text-[#344152] px-3 py-1 rounded-full text-xs font-bold">
                                        {{ number_format($movie->total_tiket_terjual, 0, ',', '.') }} Pcs
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 text-right">
                                    Rp {{ number_format($movie->total_pendapatan, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">Tidak ada data penjualan pada periode ini.</td>
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
        document.getElementById('filterForm').submit(); // Otomatis submit
    }

    document.addEventListener("DOMContentLoaded", function() {
        const dates = {!! json_encode($dailySales->pluck('date')->map(function($date) { return \Carbon\Carbon::parse($date)->format('d M'); })) !!};
        const revenues = {!! json_encode($dailySales->pluck('revenue')) !!};

        const options = {
            series: [{ name: 'Pendapatan Harian', data: revenues }],
            chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
            colors: ['#3b82f6'],
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