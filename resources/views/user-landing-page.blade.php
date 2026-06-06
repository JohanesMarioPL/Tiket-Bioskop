@extends('layouts.user')

@section('title', 'Cinema Ticket Booking')

@section('content')
<div class="bg-[#F9FAFB] overflow-x-hidden pb-20">
    <div class="px-4 md:px-10 py-0">
        <span class="font-baloo text-[#222432] text-2xl md:text-3xl mt-8 md:mt-10 flex flex-wrap gap-1 justify-center items-center mb-8 md:mb-10 text-center font-bold">
            Hey There! Wanna watch a <span class="text-[#f5cf14]">movie?</span>
        </span>
        
        <div class="w-full h-[250px] md:h-[400px] bg-[#222432] rounded-3xl mb-10 overflow-hidden relative shadow-md">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent flex flex-col justify-center px-6 md:px-12 z-10">
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-2 md:mb-4">Cinema Ticket Booking</h2>
                <p class="text-white/80 font-medium max-w-lg text-sm md:text-base">Find Your Favorite Movies.</p>
            </div>
            <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Cinema Promo" class="w-full h-full object-cover opacity-60">
        </div>

        <div class="flex flex-row justify-between items-center grow-0 px-2 md:px-10 mt-8 md:mt-0 mb-6">
            <span class="font-baloo text-xl md:text-2xl font-bold text-[#222432]">Featured Movies</span>
            <a href="{{ url('/movies') }}" class="bg-[#222432] text-white px-5 py-2 rounded-3xl text-sm font-bold hover:bg-[#3b3e52] transition-colors">
                See all
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 px-2 md:px-10 mb-12">
            @forelse(($featuredMovies ?? [])->take(4) as $movie)
                @php
                    $startPrice = $movie->schedules->min('base_price');
                    $firstLocation = $movie->schedules->first()->studio->location->name ?? 'Bandung';
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:-translate-y-1 transition-transform group flex flex-col h-full">
                    <div class="w-full aspect-[3/4] bg-slate-200 overflow-hidden">
                        <img src="{{ $movie->poster_url ? asset('storage/' . $movie->poster_url) : 'https://via.placeholder.com/300x400' }}" class="w-full h-full object-cover" alt="{{ $movie->title }}">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-[#222432] text-base md:text-lg mb-1 min-h-[3rem] line-clamp-2 group-hover:text-[#f5cf14] transition-colors leading-tight">{{ $movie->title }}</h3>
                        <p class="text-xs font-medium text-slate-400 mb-2">SU &bull; {{ $movie->duration_minutes }} Mnt</p>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">{{ $firstLocation }}</p>
                        <div class="mt-auto">
                            <p class="text-[#f5cf14] font-bold text-sm md:text-base">
                                {{ $startPrice ? 'Rp ' . number_format($startPrice, 0, ',', '.') : 'Harga belum tersedia' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-400 text-sm py-4">Belum ada film unggulan.</div>
            @endforelse
        </div>

        <div class="mx-2 md:mx-10 mt-8 md:mt-10 mb-12">
            @if(isset($randomBanners[0]))
                <div class="w-full h-[250px] md:h-[350px] bg-[#222432] rounded-3xl overflow-hidden relative group shadow-md">
                    <img src="{{ $randomBanners[0]->poster_url ? asset('storage/' . $randomBanners[0]->poster_url) : 'https://via.placeholder.com/1200x500' }}" class="w-full h-full object-cover opacity-50 group-hover:scale-105 group-hover:opacity-60 transition-all duration-700">
                    <div class="absolute bottom-0 left-0 p-6 md:p-10 w-full bg-gradient-to-t from-black/80 to-transparent">
                        <span class="bg-[#f5cf14] text-white px-3 py-1 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-wider mb-3 inline-block">Spotlight</span>
                        <h2 class="text-2xl md:text-4xl font-extrabold text-white mb-3">{{ $randomBanners[0]->title }}</h2>
                        <a href="#" class="inline-block bg-white text-[#222432] px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-100 transition-colors">
                            Get Tickets
                        </a>
                    </div>
                </div>
            @else
                <div class="w-full max-w-7xl mx-auto h-[250px] md:h-[350px] bg-slate-200 rounded-3xl animate-pulse flex items-center justify-center text-slate-400">Loading Spotlight...</div>
            @endif
        </div>
        
        <div class="flex flex-row justify-between items-center grow-0 mt-8 md:mt-12 mb-6 md:mb-10 px-2 md:px-10">
            <span class="font-baloo text-xl md:text-2xl font-bold text-[#222432]">Top Movies</span>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 px-2 md:px-10 mb-12 max-w-full">
            @php
                $rankRotations = ["rotate-12", "-rotate-12", "-rotate-12", "rotate-6"];
                $rankColors = ["bg-[#FFD700]", "bg-[#C0C0C0]", "bg-[#CD7F32]", "bg-[#23222c]"];
            @endphp

            @forelse(($topMovies ?? [])->take(4) as $index => $movie)
                @php
                    $startPrice = $movie->schedules->min('base_price');
                    $firstLocation = $movie->schedules->first()->studio->location->name ?? 'Bandung';
                @endphp
                <div class="relative w-full hover:-translate-y-2 transition-transform duration-300">
                    <div class="absolute -top-4 -right-2 z-10">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full {{ $rankColors[$index] }} text-white flex items-center justify-center font-black text-xl md:text-2xl shadow-lg border-2 border-white {{ $rankRotations[$index] }}">
                            {{ $index + 1 }}
                        </div>
                    </div>
                
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden h-full flex flex-col">
                        <div class="w-full aspect-[3/4] bg-slate-200 overflow-hidden">
                            <img src="{{ $movie->poster_url ? asset('storage/' . $movie->poster_url) : 'https://via.placeholder.com/300x400' }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-bold text-[#222432] text-base md:text-lg mb-1 min-h-[3rem] line-clamp-2 leading-tight">{{ $movie->title }}</h3>
                            <p class="text-xs font-medium text-slate-400 mb-2">{{ $movie->genre }}</p>
                            <div class="text-xs text-slate-500 space-y-1 mt-auto">
                                <p class="flex items-center gap-1">{{ $firstLocation }}</p>
                                <p class="flex items-center gap-1 font-bold text-[#f5cf14]">
                                    {{ $startPrice ? 'Rp ' . number_format($startPrice, 0, ',', '.') : 'TBD' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-400 py-10 font-medium">Belum ada film terpopuler...</div>
            @endforelse
        </div>

        <div class="mx-2 md:mx-10 mt-10 md:mt-20 mb-12"> 
            @if(isset($randomBanners[1]))
                 <div class="w-full h-[250px] md:h-[350px] bg-[#222432] rounded-3xl overflow-hidden relative group shadow-md">
                    <img src="{{ $randomBanners[1]->poster_url ? asset('storage/' . $randomBanners[1]->poster_url) : 'https://via.placeholder.com/1200x500' }}" class="w-full h-full object-cover opacity-50 group-hover:scale-105 group-hover:opacity-60 transition-all duration-700">
                    <div class="absolute bottom-0 left-0 p-6 md:p-10 w-full bg-gradient-to-t from-black/80 to-transparent">
                        <span class="bg-indigo-500 text-white px-3 py-1 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-wider mb-3 inline-block">Must Watch</span>
                        <h2 class="text-2xl md:text-4xl font-extrabold text-white mb-3">{{ $randomBanners[1]->title }}</h2>
                        <a href="#" class="inline-block bg-white text-[#222432] px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-100 transition-colors">
                            Get Tickets
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-row justify-between items-center grow-0 px-2 md:px-10 mt-8 md:mt-10 mb-6">
            <span class="font-baloo text-xl md:text-2xl font-bold text-[#222432]">Upcoming This Week</span>
            <a href="{{ url('/movies') }}" class="bg-[#222432] text-white px-5 py-2 rounded-3xl text-sm font-bold hover:bg-[#3b3e52] transition-colors shadow-sm">
                See all
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 px-2 md:px-10 pb-8">
            @forelse(($featuredMovies ?? [])->take(4) as $movie)
                @php
                    $startPrice = $movie->schedules->min('base_price');
                    $firstLocation = $movie->schedules->first()->studio->location->name ?? 'Bandung';
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:-translate-y-1 transition-transform group flex flex-col h-full">
                    <div class="w-full aspect-[3/4] bg-slate-200 overflow-hidden">
                        <img src="{{ $movie->poster_url ? asset('storage/' . $movie->poster_url) : 'https://via.placeholder.com/300x400' }}" class="w-full h-full object-cover" alt="{{ $movie->title }}">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-[#222432] text-base md:text-lg mb-1 min-h-[3rem] line-clamp-2 group-hover:text-[#f5cf14] transition-colors leading-tight">{{ $movie->title }}</h3>
                        <p class="text-xs font-medium text-slate-500 mt-1 mb-3">SU &bull; {{ $movie->duration_minutes }} Mnt</p>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mb-4">{{ $firstLocation }}</p>
                        <div class="mt-auto">
                            <p class="text-[#f5cf14] font-bold text-sm md:text-base">
                                {{ $startPrice ? 'Rp ' . number_format($startPrice, 0, ',', '.') : 'Harga belum tersedia' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full text-center text-slate-400 text-sm py-4">Belum ada rilis minggu ini.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection