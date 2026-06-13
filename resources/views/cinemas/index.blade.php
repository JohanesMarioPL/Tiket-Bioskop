@extends('layouts.user')

@section('title', 'Cari Bioskop')

@section('content')
<div class="bg-[#FAF3E0] min-h-screen pb-20 font-baloo">
    <div class="max-w-4xl mx-auto px-4 md:px-10 py-6">
        
        <nav class="text-sm text-slate-500 mb-4">
            <a href="{{ route('landing') }}" class="hover:text-[#4B3935]">Beranda</a> / <span class="text-slate-800 font-semibold">Bioskop</span>
        </nav>

        <h1 class="text-3xl md:text-4xl font-black text-[#4B3935] mb-6">Bioskop</h1>

        <form action="{{ route('cinemas.index') }}" method="GET" id="filterForm" class="space-y-4 mb-8">
            
            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-[#C8C2BC]/40 w-fit">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kota:</span>
                <select name="city" onchange="document.getElementById('filterForm').submit()" class="bg-transparent text-sm font-bold text-[#4B3935] focus:outline-none cursor-pointer">
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ $selectedCity == $city ? 'selected' : '' }}>
                            {{ strtoupper($city) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari bioskop di {{ strtoupper($selectedCity) }}..." 
                    class="w-full bg-white border border-[#C8C2BC]/50 pl-12 pr-4 py-3.5 rounded-full text-base text-[#4B3935] placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4B3935]/20 transition-all"
                >
                @if(request('search'))
                    <a href="{{ route('cinemas.index', ['city' => $selectedCity]) }}" class="absolute inset-y-0 right-4 flex items-center text-xs font-bold text-red-500 hover:underline">
                        Hapus Filter
                    </a>
                @endif
            </div>
        </form>

        <div class="space-y-4">
            @forelse($cinemas as $cinema)
                <a href="{{ route('cinemas.show', $cinema->id) }}" class="flex items-center justify-between bg-white p-6 rounded-2xl border border-[#C8C2BC]/30 shadow-sm hover:translate-x-1 transition-all group">
                    <div class="space-y-2">
                        <h2 class="text-xl font-extrabold text-[#4B3935] uppercase tracking-wide group-hover:text-teal-600 transition-colors">
                            {{ $cinema->name }}
                        </h2>
                        <p class="text-xs text-slate-500 font-medium max-w-xl leading-relaxed">
                            {{ $cinema->address }}
                        </p>
                        
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach($cinema->studios->pluck('studio_type')->unique() as $type)
                                <span class="bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold px-3 py-1 rounded-md tracking-wider">
                                    {{ $type }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-slate-400 group-hover:text-teal-600 transition-colors pl-4">
                        <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            @empty
                <div class="bg-white/60 rounded-2xl border border-dashed border-[#C8C2BC] p-12 text-center text-slate-400 font-medium">
                    Tidak ada bioskop ditemukan di kota {{ ucfirst($selectedCity) }}.
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection