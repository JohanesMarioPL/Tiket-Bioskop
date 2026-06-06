@extends('layouts.user')

@section('title', 'Riwayat Transaksi – TiketBioskop')

@section('content')
<div class="bg-[#FAF3E0] min-h-screen pb-20" x-data="{ showReviewModal: false, selectedMovieId: null, selectedMovieTitle: '', selectedMoviePoster: '', rating: 0, comment: '' }">
    <main class="max-w-6xl mx-auto px-6 py-10">

        {{-- Page Header --}}
        <div class="mb-10">
            <h2 class="font-baloo text-3xl font-extrabold text-[#4B3935]">Riwayat Transaksi</h2>
            <p class="text-sm mt-1 text-[#4B3935]/70">Semua transaksi pemesanan tiket bioskop kamu.</p>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-bold shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($transactions->isEmpty())
            {{-- Empty State --}}
            <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-[#C8C2BC] shadow-sm">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-[#CBDFEA]/40 mb-5">
                    <svg class="w-10 h-10 text-[#708090]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-lg font-bold text-[#708090]">Belum ada riwayat transaksi</p>
                <p class="text-sm text-[#708090]/70 mt-1 mb-6">Yuk, pesan tiket film favoritmu sekarang!</p>
                <a href="{{ route('movies.index') }}" class="inline-block bg-[#4B3935] text-[#FAF3E0] text-sm font-bold px-8 py-3 rounded-xl hover:bg-[#5c4944] transition-colors shadow-md">
                    Jelajahi Film
                </a>
            </div>
        @else
            {{-- Transaction Cards --}}
            <div class="space-y-5">
                @foreach($transactions as $transaction)
                    @php
                        $firstTicket = $transaction->tickets->first();
                        $movie = $firstTicket?->schedule?->movie;
                        $studio = $firstTicket?->schedule?->studio;
                        $location = $studio?->location;
                        $seats = $transaction->tickets->map(function($ticket) {
                            return $ticket->reservation?->seat?->seat_number ?? null;
                        })->filter()->sort()->values();
                        $ticketCount = $transaction->tickets->count();
                        $scheduleTime = $firstTicket?->schedule?->start_time;
                    @endphp

                    <div class="bg-white rounded-2xl border border-[#C8C2BC]/30 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <div class="flex flex-col md:flex-row">

                            {{-- Movie Poster --}}
                            <div class="w-full md:w-36 h-44 md:h-auto flex-shrink-0 bg-gradient-to-br from-[#CBDFEA] to-[#C8C2BC] relative overflow-hidden">
                                @if($movie?->poster_url)
                                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/60" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h2v2H4zm0 5h2v2H4zm0 5h2v2H4zm16-10h-2v2h2zm0 5h-2v2h2zm0 5h-2v2h2zM8 4h8v16H8z"/></svg>
                                    </div>
                                @endif

                                {{-- Status Badge (overlay on poster) --}}
                                <div class="absolute top-3 left-3">
                                    @if($transaction->status === 'paid')
                                        <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-widest rounded-full bg-green-500 text-white shadow-sm">Lunas</span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-widest rounded-full bg-amber-400 text-white shadow-sm">Pending</span>
                                    @elseif($transaction->status === 'success')
                                        <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-widest rounded-full bg-green-500 text-white shadow-sm">Sukses</span>
                                    @else
                                        <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-widest rounded-full bg-red-400 text-white shadow-sm">{{ ucfirst($transaction->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Card Content --}}
                            <div class="flex-1 p-5 md:p-6 flex flex-col justify-between">
                                <div>
                                    {{-- Movie Title & Code --}}
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-4">
                                        <div>
                                            <h3 class="font-bold text-lg text-[#4B3935] leading-tight">
                                                {{ $movie?->title ?? 'Film Tidak Diketahui' }}
                                            </h3>
                                            @if($movie?->genre)
                                                <span class="text-[10px] font-bold text-[#708090] uppercase tracking-wider">
                                                    {{ $movie->genre }}
                                                    @if($movie->rating_age) • {{ $movie->rating_age }} @endif
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs font-mono font-black text-[#4B3935]/50 tracking-wider bg-[#FAF3E0] px-3 py-1 rounded-lg self-start flex-shrink-0">
                                            #{{ $transaction->transaction_code }}
                                        </span>
                                    </div>

                                    {{-- Details Grid --}}
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <span class="block text-[9px] font-extrabold uppercase tracking-widest text-[#708090] mb-0.5">Tanggal</span>
                                            <span class="text-xs font-bold text-[#4B3935]">
                                                {{ $transaction->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="block text-[9px] font-extrabold uppercase tracking-widest text-[#708090] mb-0.5">Jadwal</span>
                                            <span class="text-xs font-bold text-[#4B3935]">
                                                {{ $scheduleTime ? \Carbon\Carbon::parse($scheduleTime)->format('d M Y - H:i') : '-' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="block text-[9px] font-extrabold uppercase tracking-widest text-[#708090] mb-0.5">Bioskop</span>
                                            <span class="text-xs font-bold text-[#4B3935]">
                                                {{ $location?->name ?? '-' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="block text-[9px] font-extrabold uppercase tracking-widest text-[#708090] mb-0.5">Kursi ({{ $ticketCount }}x)</span>
                                            <span class="text-xs font-bold text-[#4B3935]">
                                                {{ $seats->isNotEmpty() ? $seats->implode(', ') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Bottom: Price & Actions --}}
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-4 border-t border-[#C8C2BC]/20">
                                    <div>
                                        <span class="text-[9px] font-extrabold uppercase tracking-widest text-[#708090]">Total Pembayaran</span>
                                        <p class="text-lg font-extrabold text-[#4B3935]">
                                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="flex gap-2 flex-wrap">
                                        {{-- View Ticket --}}
                                        @if(in_array($transaction->status, ['paid', 'success']))
                                            <a href="{{ route('ticket.show', $transaction) }}" class="inline-flex items-center gap-1.5 bg-[#4B3935] text-[#FAF3E0] text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-[#5c4944] transition-colors shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                                Lihat Tiket
                                            </a>
                                        @endif

                                        {{-- Pay Now --}}
                                        @if($transaction->status === 'pending')
                                            <a href="{{ route('payment.show', $transaction) }}" class="inline-flex items-center gap-1.5 bg-amber-500 text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-amber-600 transition-colors shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                                Bayar Sekarang
                                            </a>
                                        @endif

                                        {{-- Review Button --}}
                                        @if($transaction->status === 'paid' && ($movieId = ($firstTicket?->schedule?->movie_id ?? null)))
                                            <button
                                                type="button"
                                                @click="showReviewModal = true; selectedMovieId = '{{ $movieId }}'; selectedMovieTitle = '{{ addslashes($movie->title ?? '') }}'; selectedMoviePoster = '{{ $movie->poster_url ?? '' }}'; rating = 0; comment = ''"
                                                class="inline-flex items-center gap-1.5 bg-[#CBDFEA] text-[#4B3935] text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-[#b8d1e0] transition-colors shadow-sm"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z"/></svg>
                                                Beri Rating
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    {{-- Review Modal --}}
    <div x-show="showReviewModal"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition.opacity
         style="display: none;">

        <div class="bg-[#CBDFEA] rounded-2xl max-w-lg w-full p-8 shadow-2xl relative"
             @click.away="showReviewModal = false"
             x-transition.scale>

            {{-- Close --}}
            <button type="button" @click="showReviewModal = false" class="absolute top-4 right-4 text-[#4B3935]/60 hover:text-[#4B3935] transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="movie_id" :value="selectedMovieId">
                <input type="hidden" name="rating" :value="rating">

                {{-- Movie Info --}}
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-[#4B3935]/10">
                    <div class="w-16 h-20 bg-[#C8C2BC]/40 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                        <template x-if="selectedMoviePoster">
                            <img :src="selectedMoviePoster" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!selectedMoviePoster">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white/60" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h2v2H4zm0 5h2v2H4zm0 5h2v2H4zm16-10h-2v2h2zm0 5h-2v2h2zm0 5h-2v2h2zM8 4h8v16H8z"/></svg>
                            </div>
                        </template>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-[#4B3935]/60 mb-1">Menulis ulasan untuk</p>
                        <h2 class="text-xl font-extrabold text-[#4B3935]" x-text="selectedMovieTitle"></h2>
                    </div>
                </div>

                {{-- Star Rating --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-extrabold uppercase tracking-widest mb-2 text-[#4B3935]">Berikan Rating</label>
                    <div class="flex gap-2">
                        <template x-for="i in 5">
                            <button type="button"
                                    class="hover:scale-110 transition-all duration-200 focus:outline-none"
                                    :class="i <= rating ? 'text-[#F59E0B]' : 'text-[#C8C2BC]'"
                                    @click="rating = i">
                                <svg class="w-10 h-10 fill-current drop-shadow-sm" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z"/></svg>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Comment --}}
                <div class="mb-6">
                    <label for="comment" class="block text-[11px] font-extrabold uppercase tracking-widest mb-2 text-[#4B3935]">Komentar (Opsional)</label>
                    <textarea name="comment"
                              x-model="comment"
                              rows="4"
                              placeholder="Bagaimana menurutmu filmnya?"
                              class="w-full bg-[#FAF3E0] border-none rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-[#4B3935] outline-none text-[#4B3935] font-medium placeholder:font-normal placeholder:opacity-50 resize-none"></textarea>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-[#4B3935]/10">
                    <button type="button"
                            @click="showReviewModal = false"
                            class="bg-[#FAF3E0] text-[#4B3935] border border-[#4B3935]/20 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-white transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            :disabled="rating === 0"
                            class="bg-[#4B3935] text-[#FAF3E0] px-8 py-3 rounded-xl text-sm font-bold hover:bg-[#5c4944] transition-colors shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
