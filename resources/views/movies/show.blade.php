@extends('layouts.user')

@section('title', $movie->title . ' – Tiket Bioskop')

@section('content')
<style>
    .hero-backdrop {
        background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-backdrop::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 70% 50%, rgba(203,223,234,0.15) 0%, transparent 60%);
        pointer-events: none;
    }

    .poster-box {
        background: linear-gradient(135deg, var(--blue) 0%, var(--gray) 100%);
        border-radius: 1rem;
        overflow: hidden;
        aspect-ratio: 2/3;
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.3rem 0.8rem;
        border-radius: 9999px;
    }

    .badge-genre {
        background-color: rgba(203,223,234,0.2);
        color: var(--blue);
        border: 1px solid rgba(203,223,234,0.4);
    }

    .badge-rating {
        background-color: rgba(250,243,224,0.15);
        color: var(--cream);
        border: 1px solid rgba(250,243,224,0.3);
    }

    .schedule-card {
        background: white;
        border: 1px solid var(--gray);
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
    }

    .schedule-card:hover {
        border-color: var(--brown);
        box-shadow: 0 4px 20px rgba(75,57,53,0.12);
        transform: translateY(-2px);
    }

    .time-badge {
        background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);
        color: var(--cream);
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        text-align: center;
        min-width: 90px;
        flex-shrink: 0;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);
        color: var(--cream);
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        padding: 0.6rem 1.4rem;
        border-radius: 0.6rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: opacity 0.2s, transform 0.15s;
        white-space: nowrap;
    }

    .btn-primary:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--gray);
        text-decoration: none;
        letter-spacing: 0.05em;
        transition: color 0.2s;
    }

    .btn-back:hover { color: var(--blue); }

    .info-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.78rem;
        color: var(--gray);
    }

    .divider-dot {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: var(--gray);
        flex-shrink: 0;
    }

    .empty-schedule {
        background: white;
        border: 2px dashed var(--gray);
        border-radius: 1rem;
        padding: 3rem;
        text-align: center;
    }
</style>

{{-- ── HERO: Film Info ── --}}
<div class="hero-backdrop">
    <div class="max-w-6xl mx-auto px-6 py-10 relative z-10">

        {{-- Back button --}}
        <div class="flex flex-wrap items-center gap-3 mb-8">
            <a href="{{ route('landing') }}" class="btn-back">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda / Dashboard
            </a>
            <span class="text-[var(--gray)] opacity-40">|</span>
            <a href="{{ route('movies.index') }}" class="btn-back">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Film
            </a>
        </div>

        <div class="flex flex-col md:flex-row gap-8 md:gap-12">

            {{-- Poster --}}
            <div class="poster-box w-full md:w-52 flex-shrink-0 self-start">
                <img src="{{ $movie->poster_url }}" class="w-full h-full object-cover" alt="{{ $movie->title }}" />
            </div>

            {{-- Info --}}
            <div class="flex-1 flex flex-col justify-center">

                {{-- Badges --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="badge badge-genre">{{ $movie->genre }}</span>
                    <span class="badge badge-rating">{{ $movie->rating_age }}</span>
                </div>

                <h1 class="text-3xl md:text-4xl font-black leading-tight mb-4" style="color: var(--cream);">
                    {{ $movie->title }}
                </h1>

                {{-- Meta row --}}
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <div class="info-row">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $movie->duration_minutes }} menit
                    </div>
                    <div class="divider-dot"></div>
                    <div class="info-row">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                        </svg>
                        {{ $schedules->count() }} jadwal tersedia
                    </div>
                </div>

                <p class="text-sm leading-relaxed" style="color: rgba(250,243,224,0.75); max-width: 680px;">
                    {{ $movie->description }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ── MAIN: Jadwal Tayang ── --}}
<main class="max-w-6xl mx-auto px-6 py-10 pb-20">

    <div class="mb-6">
        <h2 class="text-xl font-bold text-[#4B3935]">Jadwal Tayang</h2>
        <p class="text-sm mt-1" style="color: var(--brown); opacity: 0.85;">Pilih jadwal yang tersedia untuk membeli tiket.</p>
    </div>

    @if($schedules->isEmpty())
        <div class="empty-schedule">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-30" style="color: var(--slate);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-base font-bold" style="color: var(--slate);">Belum ada jadwal tersedia.</p>
            <p class="text-sm mt-1" style="color: var(--gray);">Coba kembali lagi nanti.</p>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach($schedules as $schedule)
                <div class="schedule-card">

                    {{-- Waktu --}}
                    <div class="time-badge">
                        <div class="text-[10px] font-bold opacity-60 uppercase tracking-widest">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('D') }}
                        </div>
                        <div class="text-lg font-black leading-none mt-0.5">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                        </div>
                        <div class="text-[9px] opacity-60 mt-0.5">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y') }}
                        </div>
                    </div>

                    {{-- Info Studio & Lokasi --}}
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-sm">
                            {{ $schedule->studio->studio_name ?? '-' }}
                            @if($schedule->studio->studio_type ?? false)
                                <span class="ml-2 text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded" style="background-color: var(--blue); color: var(--brown);">
                                    {{ $schedule->studio->studio_type }}
                                </span>
                            @endif
                        </div>
                        @if($schedule->studio->location ?? false)
                            <div class="info-row mt-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $schedule->studio->location->name }}
                                @if($schedule->studio->location->city)
                                    · {{ $schedule->studio->location->city }}
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Harga & Tombol Beli --}}
                    <div class="flex flex-col items-end gap-3 flex-shrink-0">
                        <div class="text-right">
                            <div class="text-[10px] font-bold uppercase tracking-widest" style="color: var(--slate);">Mulai dari</div>
                            <div class="text-lg font-black" style="color: var(--brown);">
                                Rp {{ number_format($schedule->base_price, 0, ',', '.') }}
                            </div>
                        </div>
                        <a href="{{ route('booking.show', $schedule) }}" class="btn-primary">
                            Beli Tiket
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
    {{-- Ulasan Penonton --}}
    <div class="mt-16 pt-10 border-t border-[#C8C2BC]/40">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-[#4B3935]">Ulasan Penonton</h2>
            <p class="text-sm mt-1 text-slate-500">Pendapat mereka tentang film {{ $movie->title }}.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($reviews as $review)
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-[#C8C2BC]/30 flex gap-4 hover:-translate-y-0.5 transition-transform duration-300">
                    <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-[#4B3935] text-sm" style="background-color: var(--blue);">
                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                    </div>
                    
                    <div class="flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-sm text-[#4B3935]">{{ $review->user->name ?? 'Anonim' }}</h4>
                                <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex gap-0.5 text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-3.5 h-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 text-slate-200 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed mt-3 italic">
                            "{{ $review->comment ?? 'Memberikan rating tanpa ulasan tertulis.' }}"
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 bg-white/50 rounded-2xl border-2 border-dashed border-[#C8C2BC]/40">
                    <p class="text-slate-500 font-bold opacity-60">Belum ada ulasan untuk film ini.</p>
                    <p class="text-xs text-slate-400 mt-1">Jadilah penonton pertama yang memberikan ulasan!</p>
                </div>
            @endforelse
        </div>
    </div>

</main>
@endsection
