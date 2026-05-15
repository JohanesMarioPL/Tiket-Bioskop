<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $movie->title }} – Tiket Bioskop</title>
    <meta name="description" content="{{ Str::limit($movie->description, 160) }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --cream:  #FAF3E0;
            --blue:   #CBDFEA;
            --gray:   #C8C2BC;
            --slate:  #708090;
            --brown:  #4B3935;
        }

        body {
            background-color: var(--cream);
            color: var(--brown);
            font-family: 'Figtree', sans-serif;
        }

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
</head>

<body class="min-h-screen antialiased">

    {{-- ── HEADER ── --}}
    <header style="background-color: var(--brown);" class="relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 py-12 relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-8 h-8" style="color: var(--blue);" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/>
                </svg>
                <a href="{{ route('movies.index') }}" class="text-3xl font-bold tracking-tight hover:opacity-80 transition-opacity" style="color: var(--cream);">
                    Tiket<span style="color: var(--blue);">Bioskop</span>
                </a>
            </div>
            <p class="text-xs font-bold tracking-[0.2em] uppercase" style="color: var(--gray);">
                Sistem Pemesanan Tiket Film
            </p>
        </div>
    </header>

    {{-- ── HERO: Film Info ── --}}
    <div class="hero-backdrop">
        <div class="max-w-6xl mx-auto px-6 py-10 relative z-10">

            {{-- Back button --}}
            <a href="{{ route('movies.index') }}" class="btn-back mb-8 inline-flex">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Film
            </a>

            <div class="flex flex-col md:flex-row gap-8 md:gap-12">

                {{-- Poster --}}
                <div class="poster-box w-full md:w-52 flex-shrink-0 self-start">
                    @if($movie->poster_url)
                        <img src="{{ $movie->poster_url }}" class="w-full h-full object-cover" alt="{{ $movie->title }}" />
                    @else
                        <svg class="w-16 h-16 opacity-20" style="color: var(--brown);" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/>
                        </svg>
                    @endif
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
    <main class="max-w-6xl mx-auto px-6 py-10">

        <div class="mb-6">
            <h2 class="text-xl font-bold">Jadwal Tayang</h2>
            <p class="text-sm mt-1" style="color: var(--slate);">Pilih jadwal yang tersedia untuk membeli tiket.</p>
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
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <a href="{{ route('checkout.show', $schedule) }}" class="btn-primary">
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

    </main>

    <footer class="py-10 border-t text-center mt-10" style="border-color: var(--gray); color: var(--slate);">
        <p class="text-[10px] font-bold uppercase tracking-[0.3em]">© {{ date('Y') }} TIKETBIOSKOP</p>
    </footer>

</body>
</html>
