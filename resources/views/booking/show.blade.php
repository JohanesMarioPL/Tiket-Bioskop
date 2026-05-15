<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Kursi – {{ $schedule->movie->title }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --cream:  #FAF3E0;
            --blue:   #CBDFEA;
            --gray:   #C8C2BC;
            --slate:  #708090;
            --brown:  #4B3935;
            --accent: #D4AF37; /* Gold for premium feel */
        }

        body {
            background-color: var(--cream);
            color: var(--brown);
            font-family: 'Figtree', sans-serif;
        }

        .screen {
            background: linear-gradient(to bottom, var(--gray) 0%, transparent 100%);
            height: 10px;
            width: 80%;
            margin: 2rem auto;
            border-radius: 50%;
            box-shadow: 0 15px 25px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
        }

        .screen-label {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: var(--slate);
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 10px;
            max-width: 600px;
            margin: 3rem auto;
        }

        .seat {
            aspect-ratio: 1;
            border-radius: 6px;
            background-color: white;
            border: 2px solid var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .seat:hover:not(.reserved) {
            border-color: var(--brown);
            transform: scale(1.1);
        }

        .seat.selected {
            background-color: var(--brown);
            border-color: var(--brown);
            color: white;
        }

        .seat.reserved {
            background-color: var(--gray);
            border-color: var(--gray);
            color: rgba(0,0,0,0.2);
            cursor: not-allowed;
            opacity: 0.5;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .legend-box {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1px solid var(--gray);
        }

        .booking-summary {
            background-color: white;
            border-radius: 1.5rem;
            border: 1px solid var(--gray);
            padding: 2rem;
            position: sticky;
            top: 2rem;
        }

        .btn-pay {
            background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);
            color: var(--cream);
            width: 100%;
            padding: 1rem;
            border-radius: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: opacity 0.2s;
            margin-top: 1.5rem;
        }

        .btn-pay:hover { opacity: 0.9; }
        .btn-pay:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>

<body class="min-h-screen antialiased">

    <header style="background-color: var(--brown);" class="relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 py-6 relative z-10 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" style="color: var(--blue);" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/>
                </svg>
                <h1 class="text-xl font-bold tracking-tight" style="color: var(--cream);">
                    Pilih<span style="color: var(--blue);">Kursi</span>
                </h1>
            </div>
            <a href="{{ route('movies.show', $schedule->movie_id) }}" class="text-[10px] font-bold text-white opacity-60 uppercase tracking-widest hover:opacity-100">Batal</a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            {{-- Left Side: Seat Selection --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
                    <div class="screen">
                        <div class="screen-label">Layar Bioskop</div>
                    </div>

                    <div class="seat-grid" id="seatGrid">
                        @foreach($seats as $seat)
                            @php $isReserved = in_array($seat->id, $reservedSeatIds); @endphp
                            <div class="seat {{ $isReserved ? 'reserved' : '' }}" 
                                 data-id="{{ $seat->id }}" 
                                 data-number="{{ $seat->seat_number }}"
                                 onclick="toggleSeat(this)">
                                {{ $seat->seat_number }}
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-center gap-8 mt-10 border-t pt-8">
                        <div class="legend-item">
                            <div class="legend-box" style="background-color: white;"></div>
                            Tersedia
                        </div>
                        <div class="legend-item">
                            <div class="legend-box" style="background-color: var(--brown);"></div>
                            Dipilih
                        </div>
                        <div class="legend-item">
                            <div class="legend-box" style="background-color: var(--gray);"></div>
                            Terisi
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Booking Summary --}}
            <div>
                <div class="booking-summary">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="flex gap-4 mb-6 pb-6 border-b">
                        <div class="w-16 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            @if($schedule->movie->poster_url)
                                <img src="{{ $schedule->movie->poster_url }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-sm mb-1">{{ $schedule->movie->title }}</h4>
                            <p class="text-[10px] font-bold text-slate-500 uppercase">{{ $schedule->studio->studio_name }} ({{ $schedule->studio->studio_type }})</p>
                            <p class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Kursi Terpilih</span>
                            <span class="font-bold" id="selectedSeatsText">-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Harga Tiket (x<span id="ticketCount">0</span>)</span>
                            <span class="font-bold">Rp <span id="basePriceTotal">0</span></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Biaya Layanan</span>
                            <span class="font-bold">Rp <span id="serviceFee">0</span></span>
                        </div>
                    </div>

                    <div class="pt-6 border-t">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-sm">Total Bayar</span>
                            <span class="text-xl font-black text-brown-900">Rp <span id="totalAmount">0</span></span>
                        </div>
                    </div>

                    <form id="bookingForm" method="POST" action="#">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <input type="hidden" name="selected_seats" id="selectedSeatsInput">
                        <button type="submit" class="btn-pay" id="btnPay" disabled>Lanjut Pembayaran</button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script>
        const basePrice = {{ $schedule->base_price }};
        const serviceFeePerTicket = 2000;
        let selectedSeats = [];

        function toggleSeat(el) {
            if (el.classList.contains('reserved')) return;

            const seatId = el.getAttribute('data-id');
            const seatNumber = el.getAttribute('data-number');

            if (el.classList.contains('selected')) {
                el.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s.id !== seatId);
            } else {
                el.classList.add('selected');
                selectedSeats.push({ id: seatId, number: seatNumber });
            }

            updateSummary();
        }

        function updateSummary() {
            const count = selectedSeats.length;
            const selectedNumbers = selectedSeats.map(s => s.number).join(', ');
            
            document.getElementById('selectedSeatsText').innerText = count > 0 ? selectedNumbers : '-';
            document.getElementById('ticketCount').innerText = count;
            
            const baseTotal = count * basePrice;
            const feeTotal = count > 0 ? count * serviceFeePerTicket : 0;
            const total = baseTotal + feeTotal;

            document.getElementById('basePriceTotal').innerText = baseTotal.toLocaleString('id-ID');
            document.getElementById('serviceFee').innerText = feeTotal.toLocaleString('id-ID');
            document.getElementById('totalAmount').innerText = total.toLocaleString('id-ID');
            
            document.getElementById('selectedSeatsInput').value = selectedSeats.map(s => s.id).join(',');
            document.getElementById('btnPay').disabled = count === 0;
        }
    </script>

</body>
</html>
