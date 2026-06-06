@extends('layouts.user')

@section('title', 'E-Ticket: #' . $transaction->transaction_code . ' – TiketBioskop')

@section('content')
<style>
    .ticket-card {
        background: #ffffff;
        border-radius: 2rem;
        position: relative;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(200, 194, 188, 0.2);
    }

    .ticket-notch-left, .ticket-notch-right {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #FAF3E0;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }

    .ticket-notch-left {
        left: -16px;
        box-shadow: inset -5px 0 8px rgba(0, 0, 0, 0.03);
        border-right: 1px solid rgba(200, 194, 188, 0.15);
    }

    .ticket-notch-right {
        right: -16px;
        box-shadow: inset 5px 0 8px rgba(0, 0, 0, 0.03);
        border-left: 1px solid rgba(200, 194, 188, 0.15);
    }

    .ticket-divider {
        width: 100%;
        border-top: 2px dashed rgba(200, 194, 188, 0.4);
    }

    @media print {
        body { background-color: #ffffff; }
        .no-print { display: none !important; }
        .ticket-card {
            box-shadow: none !important;
            border: 2px solid #000000 !important;
        }
        .ticket-notch-left, .ticket-notch-right {
            background-color: #ffffff !important;
            border: 1px solid #000000 !important;
        }
        nav, footer { display: none !important; }
    }
</style>

<div class="bg-[#FAF3E0] min-h-screen pb-20">
    <main class="max-w-md w-full mx-auto px-6 py-10 space-y-8">

        {{-- Header --}}
        <div class="flex justify-between items-center no-print">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-[#4B3935]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/>
                </svg>
                <span class="font-baloo text-xl font-black text-[#4B3935] uppercase tracking-tight">E-Ticket</span>
            </div>
            <a href="{{ route('movies.index') }}" class="text-xs font-bold text-[#708090] hover:text-[#4B3935] flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                Halaman Utama
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-xs font-bold shadow-sm no-print flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Ticket Card --}}
        <div class="ticket-card overflow-hidden">

            {{-- Upper Section --}}
            <div class="p-8 pb-6 space-y-6">
                <div class="flex gap-4">
                    <div class="w-16 h-22 bg-gradient-to-br from-[#CBDFEA] to-[#C8C2BC] rounded-xl overflow-hidden flex-shrink-0 border border-[#C8C2BC]/20 shadow-sm">
                        @if($transaction->tickets->first()->schedule->movie->poster_url ?? false)
                            <img src="{{ $transaction->tickets->first()->schedule->movie->poster_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-[10px] text-[#708090] font-bold">Poster</div>
                        @endif
                    </div>
                    <div class="flex-grow flex flex-col justify-center">
                        <span class="px-2 py-0.5 self-start text-[8px] font-black rounded bg-green-50 text-green-800 border border-green-200/60 mb-1.5 uppercase tracking-wide">
                            Paid / Lunas
                        </span>
                        <h3 class="font-extrabold text-lg text-[#4B3935] leading-tight mb-0.5">
                            {{ $transaction->tickets->first()->schedule->movie->title ?? 'Film Tidak Diketahui' }}
                        </h3>
                        <p class="text-[10px] font-bold text-[#708090] uppercase tracking-wider">
                            {{ $transaction->tickets->first()->schedule->movie->rating_age ?? 'R13' }} • {{ $transaction->tickets->first()->schedule->movie->genre ?? 'Drama' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-y-4 gap-x-6 pt-2 border-t border-[#C8C2BC]/15">
                    <div>
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#708090]">Bioskop</span>
                        <p class="text-xs font-bold text-[#4B3935] mt-0.5">
                            {{ $transaction->tickets->first()->schedule->studio->location->name ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#708090]">Studio</span>
                        <p class="text-xs font-bold text-[#4B3935] mt-0.5">
                            {{ $transaction->tickets->first()->schedule->studio->studio_name ?? '-' }} ({{ $transaction->tickets->first()->schedule->studio->studio_type ?? '-' }})
                        </p>
                    </div>
                    <div>
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#708090]">Tanggal & Waktu</span>
                        <p class="text-xs font-bold text-[#4B3935] mt-0.5">
                            {{ isset($transaction->tickets->first()->schedule->start_time) ? \Carbon\Carbon::parse($transaction->tickets->first()->schedule->start_time)->translatedFormat('d M Y - H:i') : '-' }} WIB
                        </p>
                    </div>
                    <div>
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#708090]">Nomor Kursi</span>
                        <p class="text-sm font-black text-[#4B3935] mt-0.5 tracking-wide">
                            {{ $transaction->tickets->map(function($ticket) { return $ticket->reservation->seat->seat_number ?? '-'; })->sort()->implode(', ') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="relative flex items-center h-0">
                <div class="ticket-notch-left"></div>
                <div class="ticket-divider mx-4"></div>
                <div class="ticket-notch-right"></div>
            </div>

            {{-- Lower Section --}}
            <div class="p-8 pt-6 bg-[#CBDFEA]/10 flex flex-col items-center justify-center text-center">
                <div class="p-3 bg-white rounded-2xl border border-[#C8C2BC]/20 shadow-md w-36 h-36 flex items-center justify-center mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Tiket%20berhasil%20di-scan" alt="QR Code Tiket Berhasil di-Scan" class="w-full h-full object-contain">
                </div>

                <span class="text-[9px] font-black uppercase tracking-widest text-[#708090] mb-1">Kode Transaksi</span>
                <p class="font-mono font-black text-[#4B3935] text-lg tracking-wider mb-4">
                    {{ $transaction->transaction_code }}
                </p>

                <p class="text-[10px] text-[#708090] font-medium leading-relaxed max-w-[280px]">
                    Tunjukkan QR Code ini kepada petugas bioskop saat masuk. Pembayaran berhasil via <span class="font-bold uppercase text-[#4B3935]">{{ $transaction->payment->payment_method ?? 'METODE LAIN' }}</span>.
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-4 no-print">
            <button
                type="button"
                onclick="window.print()"
                class="flex-1 bg-white hover:bg-[#CBDFEA]/20 text-[#4B3935] font-bold py-3.5 px-6 rounded-xl border border-[#C8C2BC]/30 text-sm shadow-sm transition-all flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.615 0-1.115-.479-1.12-1.095L5.83 18M10.5 8.25h3M8.25 18h7.5m-7.5-6h7.5"/>
                </svg>
                <span>Cetak Tiket</span>
            </button>
            <a
                href="{{ route('transactions.history') }}"
                class="flex-1 bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] font-bold py-3.5 px-6 rounded-xl text-center text-sm shadow-md transition-all flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4 text-[#CBDFEA]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span>Riwayat Transaksi</span>
            </a>
        </div>
    </main>
</div>
@endsection
