@extends('layouts.user')

@section('title', 'Pilih Kursi – ' . $schedule->movie->title)

@section('content')
<style>
    .seat {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .seat.available:hover {
        transform: scale(1.15);
        background-color: #CBDFEA;
        border-color: var(--brown);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .seat.selected {
        background-color: var(--brown) !important;
        color: var(--cream) !important;
        border-color: var(--brown) !important;
        box-shadow: 0 4px 12px rgba(75, 57, 53, 0.35);
        transform: scale(1.05);
    }

    .screen-curve {
        position: relative;
        height: 30px;
        background: linear-gradient(to bottom, var(--blue) 0%, rgba(203,223,234,0.1) 100%);
        border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        filter: drop-shadow(0px 8px 16px rgba(203, 223, 234, 0.4));
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(200, 194, 188, 0.3);
    }
</style>

<div class="bg-[#FAF3E0] min-h-screen pb-20">
    <main class="max-w-6xl mx-auto px-6 py-10">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs font-bold text-[#4B3935]/50 mb-8">
            <a href="{{ route('movies.show', $schedule->movie_id) }}" class="hover:text-[#4B3935] transition-colors">{{ $schedule->movie->title }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            <span class="text-[#4B3935]">Pilih Kursi</span>
        </div>

        {{-- Page Header --}}
        <div class="mb-10">
            <h2 class="font-baloo text-3xl font-extrabold text-[#4B3935]">Pilih Kursi</h2>
            <p class="text-sm mt-1 text-[#4B3935]/70">Klik pada kursi kosong untuk memilih. Maksimal 10 kursi per transaksi.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Side: Seating Map --}}
            <div class="lg:col-span-2 glass-panel rounded-2xl p-6 sm:p-10 shadow-sm flex flex-col items-center">

                {{-- Cinema Screen --}}
                <div class="w-full max-w-lg mb-12">
                    <div class="screen-curve mb-3"></div>
                    <p class="text-[10px] font-bold text-center tracking-widest text-[#708090] uppercase">Layar Bioskop</p>
                </div>

                {{-- Legend --}}
                <div class="flex justify-center gap-6 mb-12 flex-wrap text-xs font-bold text-[#4B3935]">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-lg border-2 border-[#C8C2BC] bg-white"></div>
                        <span>Tersedia</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-lg bg-[#4B3935] border-2 border-[#4B3935]"></div>
                        <span>Pilihan Anda</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-lg bg-[#C8C2BC]/50 border-2 border-[#C8C2BC]/50"></div>
                        <span>Terisi</span>
                    </div>
                </div>

                {{-- Seat Grid --}}
                <div class="w-full overflow-x-auto py-4 flex justify-center">
                    <div class="grid gap-3 min-w-[320px]">
                        @php
                            $groupedSeats = $seats->groupBy(function($seat) {
                                return substr($seat->seat_number, 0, 1);
                            });
                        @endphp

                        @foreach($groupedSeats as $row => $rowSeats)
                            <div class="flex items-center gap-3 justify-center">
                                <span class="w-6 text-center font-extrabold text-sm text-[#708090]">{{ $row }}</span>

                                <div class="flex gap-2.5">
                                    @foreach($rowSeats as $seat)
                                        @php
                                            $isReserved = in_array($seat->id, $reservedSeatIds);
                                        @endphp

                                        @if($isReserved)
                                            <button
                                                type="button"
                                                disabled
                                                class="w-8 h-8 rounded-lg bg-[#C8C2BC]/40 border border-[#C8C2BC]/40 text-[10px] font-bold text-[#708090]/50 flex items-center justify-center cursor-not-allowed"
                                                title="Kursi {{ $seat->seat_number }} (Terisi)">
                                                {{ substr($seat->seat_number, 1) }}
                                            </button>
                                        @else
                                            <button
                                                type="button"
                                                data-seat-id="{{ $seat->id }}"
                                                data-seat-number="{{ $seat->seat_number }}"
                                                class="seat available w-8 h-8 rounded-lg bg-white border-2 border-[#C8C2BC] text-[10px] font-extrabold text-[#4B3935] flex items-center justify-center transition-all"
                                                onclick="toggleSeat(this)">
                                                {{ substr($seat->seat_number, 1) }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>

                                <span class="w-6 text-center font-extrabold text-sm text-[#708090]">{{ $row }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Side: Order details & Action --}}
            <div class="space-y-6">

                {{-- Movie Details Card --}}
                <div class="glass-panel rounded-2xl p-6 shadow-sm relative overflow-hidden">
                    <div class="flex gap-4">
                        <div class="w-20 h-28 bg-gradient-to-br from-[#CBDFEA] to-[#C8C2BC] rounded-xl overflow-hidden flex-shrink-0 shadow-md">
                            @if($schedule->movie->poster_url)
                                <img src="{{ $schedule->movie->poster_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-white/60 font-bold">Poster</div>
                            @endif
                        </div>
                        <div class="flex-1 flex flex-col justify-center">
                            <span class="px-2 py-0.5 self-start text-[10px] font-black rounded bg-[#CBDFEA] text-[#4B3935] mb-2">{{ $schedule->movie->rating_age }}</span>
                            <h3 class="font-extrabold text-lg text-[#4B3935] leading-tight mb-1">{{ $schedule->movie->title }}</h3>
                            <p class="text-xs font-bold text-[#708090] uppercase">{{ $schedule->studio->studio_name }} ({{ $schedule->studio->studio_type }})</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4 pt-6 border-t border-[#C8C2BC]/20 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-[#708090] font-medium">Lokasi Bioskop</span>
                            <span class="font-bold text-[#4B3935] text-right">{{ $schedule->studio->location->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#708090] font-medium">Jadwal Tayang</span>
                            <span class="font-bold text-[#4B3935]">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('d M Y - H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#708090] font-medium">Harga per Tiket</span>
                            <span class="font-extrabold text-[#4B3935] text-sm">Rp {{ number_format($schedule->base_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Booking Summary --}}
                <div class="glass-panel rounded-2xl p-6 shadow-sm">
                    <h3 class="font-extrabold text-lg text-[#4B3935] mb-4">Ringkasan Pilihan</h3>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-start text-xs border-b border-dashed border-[#C8C2BC]/30 pb-3">
                            <span class="text-[#708090] font-medium">Kursi Terpilih</span>
                            <span id="selected-seats-text" class="font-bold text-[#4B3935] text-right max-w-[150px] break-words">-</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-[#708090] font-medium">Jumlah Tiket</span>
                            <span id="ticket-count-text" class="font-extrabold text-[#4B3935]">0</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-[#C8C2BC]/20">
                            <span class="font-bold text-[#4B3935] text-sm">Total Harga</span>
                            <span id="total-price-text" class="text-xl font-black text-[#4B3935]">Rp 0</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout.show', $schedule) }}" method="GET" id="booking-form">
                        <input type="hidden" name="seat_ids" id="seat-ids-input" value="">
                        <button
                            type="submit"
                            id="checkout-btn"
                            disabled
                            class="w-full bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] font-extrabold py-3.5 px-6 rounded-xl text-center shadow-md transition-all disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <span>Lanjut ke Pembayaran</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    const basePrice = {{ $schedule->base_price }};
    let selectedSeats = [];

    function toggleSeat(button) {
        const seatId = button.getAttribute('data-seat-id');
        const seatNumber = button.getAttribute('data-seat-number');

        if (button.classList.contains('selected')) {
            button.classList.remove('selected');
            selectedSeats = selectedSeats.filter(item => item.id !== seatId);
        } else {
            if (selectedSeats.length >= 10) {
                alert('Anda hanya bisa memilih maksimal 10 kursi per transaksi.');
                return;
            }
            button.classList.add('selected');
            selectedSeats.push({ id: seatId, number: seatNumber });
        }

        updateSummary();
    }

    function updateSummary() {
        const count = selectedSeats.length;
        const numbers = selectedSeats.map(item => item.number).sort().join(', ');
        const ids = selectedSeats.map(item => item.id).join(',');
        const total = count * basePrice;

        document.getElementById('selected-seats-text').innerText = count > 0 ? numbers : '-';
        document.getElementById('ticket-count-text').innerText = count;
        document.getElementById('total-price-text').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('seat-ids-input').value = ids;

        const checkoutBtn = document.getElementById('checkout-btn');
        if (count > 0) {
            checkoutBtn.removeAttribute('disabled');
        } else {
            checkoutBtn.setAttribute('disabled', 'true');
        }
    }
</script>
@endsection
