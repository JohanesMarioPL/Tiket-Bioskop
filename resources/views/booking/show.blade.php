<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Kursi – {{ $schedule->movie->title }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream:  #FAF3E0;
            --blue:   #CBDFEA;
            --blue-glow: rgba(203, 223, 234, 0.4);
            --gray:   #C8C2BC;
            --slate:  #344152;
            --brown:  #4B3935;
            --occupied: #E5E7EB;
            --selected: #CBDFEA;
            --available: #FFFFFF;
        }

        body {
            background-color: var(--cream);
            color: var(--slate);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .seat {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .seat.available:hover {
            transform: scale(1.15);
            background-color: #E2EBF0;
            border-color: var(--slate);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .seat.selected {
            background-color: var(--slate) !important;
            color: var(--cream) !important;
            border-color: var(--slate) !important;
            box-shadow: 0 4px 12px rgba(52, 65, 82, 0.3);
            transform: scale(1.05);
        }

        .screen-curve {
            position: relative;
            height: 30px;
            background: linear-gradient(to bottom, var(--blue) 0%, rgba(203, 223, 234, 0.1) 100%);
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
            filter: drop-shadow(0px 8px 16px var(--blue-glow));
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body class="min-h-screen antialiased flex flex-col pb-12">

    <!-- Header -->
    <header style="background-color: var(--brown);" class="relative overflow-hidden shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-5 relative z-10 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <svg class="w-7 h-7" style="color: var(--blue);" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/>
                </svg>
                <a href="{{ route('movies.show', $schedule->movie_id) }}" class="text-2xl font-extrabold tracking-tight" style="color: var(--cream);">
                    Tiket<span style="color: var(--blue);">Bioskop</span>
                </a>
            </div>
            <a href="{{ route('movies.show', $schedule->movie_id) }}" class="text-sm font-bold flex items-center gap-2 hover:opacity-80 transition-opacity" style="color: var(--cream);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Seating Map -->
            <div class="lg:col-span-2 glass-panel rounded-3xl p-6 sm:p-10 shadow-xl flex flex-col items-center">
                <h2 class="text-xl font-extrabold text-slate-800 self-start mb-1">Pilih Kursi Anda</h2>
                <p class="text-xs text-slate-500 self-start mb-8">Klik pada kursi kosong untuk memilih. Maksimal 10 kursi per transaksi.</p>
                
                <!-- Cinema Screen -->
                <div class="w-full max-w-lg mb-12">
                    <div class="screen-curve mb-3"></div>
                    <p class="text-[10px] font-bold text-center tracking-widest text-slate-400 uppercase">Layar Bioskop</p>
                </div>

                <!-- Legend -->
                <div class="flex justify-center gap-6 mb-12 flex-wrap text-xs font-bold text-slate-600">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-lg border-2 border-slate-300 bg-white"></div>
                        <span>Tersedia</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-lg bg-slate-800 border-2 border-slate-800"></div>
                        <span>Pilihan Anda</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-lg bg-gray-200 border-2 border-gray-200"></div>
                        <span>Terisi</span>
                    </div>
                </div>

                <!-- Seat Grid -->
                <div class="w-full overflow-x-auto py-4 flex justify-center">
                    <div class="grid gap-3 min-w-[320px]">
                        @php
                            // Group seats by row character (A, B, C...)
                            $groupedSeats = $seats->groupBy(function($seat) {
                                return substr($seat->seat_number, 0, 1);
                            });
                        @endphp

                        @foreach($groupedSeats as $row => $rowSeats)
                            <div class="flex items-center gap-3 justify-center">
                                <!-- Row Label Left -->
                                <span class="w-6 text-center font-extrabold text-sm text-slate-400">{{ $row }}</span>
                                
                                <div class="flex gap-2.5">
                                    @foreach($rowSeats as $seat)
                                        @php
                                            $isReserved = in_array($seat->id, $reservedSeatIds);
                                        @endphp

                                        @if($isReserved)
                                            <button 
                                                type="button" 
                                                disabled 
                                                class="w-8 h-8 rounded-lg bg-gray-200 border border-gray-200 text-[10px] font-bold text-gray-400 flex items-center justify-center cursor-not-allowed"
                                                title="Kursi {{ $seat->seat_number }} (Terisi)">
                                                {{ substr($seat->seat_number, 1) }}
                                            </button>
                                        @else
                                            <button 
                                                type="button" 
                                                data-seat-id="{{ $seat->id }}" 
                                                data-seat-number="{{ $seat->seat_number }}"
                                                class="seat available w-8 h-8 rounded-lg bg-white border-2 border-slate-300 text-[10px] font-extrabold text-slate-800 flex items-center justify-center transition-all"
                                                onclick="toggleSeat(this)">
                                                {{ substr($seat->seat_number, 1) }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Row Label Right -->
                                <span class="w-6 text-center font-extrabold text-sm text-slate-400">{{ $row }}</span>
                             </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Side: Order details & Action Card -->
            <div class="space-y-6">
                <!-- Movie details card -->
                <div class="glass-panel rounded-3xl p-6 shadow-xl relative overflow-hidden">
                    <div class="flex gap-4">
                        <div class="w-20 h-28 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 shadow-md">
                            @if($schedule->movie->poster_url)
                                <img src="{{ $schedule->movie->poster_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-xs text-slate-400 font-bold">Poster</div>
                            @endif
                        </div>
                        <div class="flex-1 flex flex-col justify-center">
                            <span class="px-2 py-0.5 self-start text-[10px] font-black rounded bg-[#cbdfea] text-[#344152] mb-2">{{ $schedule->movie->rating_age }}</span>
                            <h3 class="font-extrabold text-lg text-slate-800 leading-tight mb-1">{{ $schedule->movie->title }}</h3>
                            <p class="text-xs font-bold text-slate-500 uppercase">{{ $schedule->studio->studio_name }} ({{ $schedule->studio->studio_type }})</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4 pt-6 border-t border-slate-200/60 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Lokasi Bioskop</span>
                            <span class="font-bold text-slate-800 text-right">{{ $schedule->studio->location->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Jadwal Tayang</span>
                            <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('d M Y - H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Harga per Tiket</span>
                            <span class="font-extrabold text-slate-800 text-sm">Rp {{ number_format($schedule->base_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Summary & Form -->
                <div class="glass-panel rounded-3xl p-6 shadow-xl">
                    <h3 class="font-extrabold text-lg text-slate-800 mb-4">Ringkasan Pilihan</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-start text-xs border-b border-dashed border-slate-200 pb-3">
                            <span class="text-slate-500 font-medium">Kursi Terpilih</span>
                            <span id="selected-seats-text" class="font-bold text-slate-800 text-right max-w-[150px] break-words">-</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500 font-medium">Jumlah Tiket</span>
                            <span id="ticket-count-text" class="font-extrabold text-slate-800">0</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-200">
                            <span class="font-bold text-slate-800 text-sm">Total Harga</span>
                            <span id="total-price-text" class="text-xl font-black text-slate-800">Rp 0</span>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <form action="{{ route('checkout.show', $schedule) }}" method="GET" id="booking-form">
                        <input type="hidden" name="seat_ids" id="seat-ids-input" value="">
                        <button 
                            type="submit" 
                            id="checkout-btn" 
                            disabled 
                            style="background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);"
                            class="w-full text-cream font-extrabold py-3.5 px-6 rounded-2xl text-center shadow-lg transition-all hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
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

    <script>
        const basePrice = {{ $schedule->base_price }};
        let selectedSeats = [];

        function toggleSeat(button) {
            const seatId = button.getAttribute('data-seat-id');
            const seatNumber = button.getAttribute('data-seat-number');

            if (button.classList.contains('selected')) {
                // Deselect seat
                button.classList.remove('selected');
                selectedSeats = selectedSeats.filter(item => item.id !== seatId);
            } else {
                // Check if maximum limit reached (e.g., 10 seats)
                if (selectedSeats.length >= 10) {
                    alert('Anda hanya bisa memilih maksimal 10 kursi per transaksi.');
                    return;
                }

                // Select seat
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

            // Update UI elements
            document.getElementById('selected-seats-text').innerText = count > 0 ? numbers : '-';
            document.getElementById('ticket-count-text').innerText = count;
            document.getElementById('total-price-text').innerText = 'Rp ' + total.toLocaleString('id-ID');
            
            // Set input value
            document.getElementById('seat-ids-input').value = ids;

            // Enable/disable checkout button
            const checkoutBtn = document.getElementById('checkout-btn');
            if (count > 0) {
                checkoutBtn.removeAttribute('disabled');
            } else {
                checkoutBtn.setAttribute('disabled', 'true');
            }
        }
    </script>

</body>
</html>
