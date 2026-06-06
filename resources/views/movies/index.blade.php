@extends('layouts.user')

@section('title', 'Daftar Film – Tiket Bioskop')

@section('content')
<style>
    .movie-card {
        background-color: white;
        border: 1px solid var(--gray);
        border-radius: 1rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .poster-placeholder {
        background: linear-gradient(135deg, var(--blue) 0%, var(--gray) 100%);
        height: 13rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .custom-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%234B3935' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
    }
</style>

<div class="bg-[#FAF3E0] min-h-screen pb-20">
    <main class="max-w-6xl mx-auto px-6 py-10">

        <div class="mb-10">
            <h2 class="text-2xl font-bold text-[#4B3935]">Daftar Film</h2>
            <p class="text-sm mt-1" style="color: var(--brown); opacity: 0.85;">Cari dan saring film yang ingin Anda tonton.</p>
        </div>

        <div class="p-6 rounded-2xl mb-12 border shadow-sm" style="background-color: var(--blue); border-color: var(--gray);">
            <form method="GET" action="{{ route('movies.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="flex-1 w-full">
                    <label for="search" class="block text-[10px] font-bold uppercase mb-2 tracking-widest" style="color: var(--brown);">Cari Judul Film</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Ketik judul..."
                        class="w-full px-4 py-2.5 rounded-lg border text-sm outline-none focus:ring-2 focus:ring-slate-300"
                        style="background-color: var(--cream); border-color: var(--gray);"
                    />
                </div>

                <div class="w-full md:w-48">
                    <label for="genre" class="block text-[10px] font-bold uppercase mb-2 tracking-widest" style="color: var(--brown);">Genre</label>
                    <select id="genre" name="genre" class="custom-select w-full px-3 py-2.5 rounded-lg border text-sm cursor-pointer outline-none" style="background-color: var(--cream); border-color: var(--gray);">
                        <option value="">Semua Genre</option>
                        @foreach($genres as $g)
                            <option value="{{ $g }}" {{ ($genre ?? '') === $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-40">
                    <label for="rating" class="block text-[10px] font-bold uppercase mb-2 tracking-widest" style="color: var(--brown);">Rating</label>
                    <select id="rating" name="rating" class="custom-select w-full px-3 py-2.5 rounded-lg border text-sm cursor-pointer outline-none" style="background-color: var(--cream); border-color: var(--gray);">
                        <option value="">Semua Rating</option>
                        @foreach($ratings as $r)
                            <option value="{{ $r }}" {{ ($rating ?? '') === $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none px-8 py-2.5 rounded-lg text-sm font-bold text-white" style="background-color: var(--brown);">
                        Cari
                    </button>
                    @if($search || $genre || $rating)
                        <a href="{{ route('movies.index') }}" class="p-2.5 rounded-lg border flex items-center justify-center" style="border-color: var(--brown); color: var(--brown);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($movies->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl border border-dashed" style="border-color: var(--gray);">
                <p class="text-lg font-bold" style="color: var(--slate);">Film tidak ditemukan.</p>
                <a href="{{ route('movies.index') }}" class="text-sm font-bold mt-4 inline-block underline">Tampilkan Semua</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($movies as $movie)
                    <div class="movie-card shadow-sm">
                        <div class="poster-placeholder rounded-t-[1rem]">
                            <img src="{{ $movie->poster_url }}" class="w-full h-full object-cover rounded-t-[1rem]" alt="{{ $movie->title }}" />
                            <div class="absolute top-3 left-3">
                                <span class="text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded-full text-white" style="background-color: var(--brown);">
                                    {{ $movie->genre }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded" style="background-color: var(--gray);">
                                    {{ $movie->rating_age }}
                                </span>
                                <div class="flex items-center gap-1 text-[10px] font-bold" style="color: var(--slate);">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $movie->duration_minutes }} Mnt
                                </div>
                            </div>
                            
                            <h3 class="text-base font-bold mb-2 line-clamp-2 leading-tight text-[#4B3935]">{{ $movie->title }}</h3>
                            <p class="text-xs leading-relaxed line-clamp-3 mb-6 flex-1" style="color: var(--slate);">
                                {{ $movie->description }}
                            </p>

                            <div class="pt-4 border-t flex justify-end" style="border-color: var(--gray);">
                                <a href="{{ route('movies.show', $movie) }}" class="text-[11px] font-bold px-5 py-2 rounded-lg text-white" style="background-color: var(--brown);">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </main>
</div>
@endsection
