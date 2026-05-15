<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout – {{ $schedule->movie->title }}</title>
    
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

        .checkout-container {
            max-width: 500px;
            margin: 4rem auto;
            background: white;
            border-radius: 2rem;
            border: 1px solid var(--gray);
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .btn-pay {
            background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);
            color: var(--cream);
            width: 100%;
            padding: 1.2rem;
            border-radius: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 2rem;
            transition: opacity 0.2s;
        }

        .btn-pay:hover { opacity: 0.9; }

        .qty-input {
            width: 100%;
            padding: 1rem;
            border-radius: 0.8rem;
            border: 2px solid var(--blue);
            font-size: 1.2rem;
            font-weight: 800;
            text-align: center;
            color: var(--brown);
            background-color: var(--cream);
            outline: none;
        }
    </style>
</head>

<body class="min-h-screen antialiased flex flex-col">

    <header style="background-color: var(--brown);" class="relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 py-6 relative z-10 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" style="color: var(--blue);" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/>
                </svg>
                <a href="{{ route('movies.show', $schedule->movie_id) }}" class="text-xl font-bold tracking-tight" style="color: var(--cream);">
                    Tiket<span style="color: var(--blue);">Bioskop</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 px-6">
        <div class="checkout-container">
            <h2 class="text-2xl font-black mb-2">Konfirmasi Pesanan</h2>
            <p class="text-sm text-slate-400 mb-8">Pilih jumlah tiket yang ingin Anda beli.</p>

            <div class="flex gap-4 mb-8">
                <div class="w-20 h-28 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                    @if($schedule->movie->poster_url)
                        <img src="{{ $schedule->movie->poster_url }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-1">{{ $schedule->movie->title }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase">{{ $schedule->studio->studio_name }} ({{ $schedule->studio->studio_type }})</p>
                    <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('d M Y, H:i') }}</p>
                </div>
            </div>

            <form action="{{ route('checkout.store', $schedule) }}" method="POST">
                @csrf
                <div class="mb-8">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Jumlah Tiket</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" class="qty-input" onchange="updateTotal()">
                </div>

                <div class="space-y-4 border-t pt-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Harga per Tiket</span>
                        <span class="font-bold">Rp {{ number_format($schedule->base_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Biaya Layanan</span>
                        <span class="font-bold">Rp <span id="feeText">2.000</span></span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="font-bold">Total Pembayaran</span>
                        <span class="text-2xl font-black">Rp <span id="totalText">{{ number_format($schedule->base_price + 2000, 0, ',', '.') }}</span></span>
                    </div>
                </div>

                <button type="submit" class="btn-pay">Bayar Sekarang</button>
            </form>
        </div>
    </main>

    <script>
        const pricePerTicket = {{ $schedule->base_price }};
        const feePerTicket = 2000;

        function updateTotal() {
            const qty = document.getElementById('quantity').value;
            const fee = qty * feePerTicket;
            const total = (qty * pricePerTicket) + fee;

            document.getElementById('feeText').innerText = fee.toLocaleString('id-ID');
            document.getElementById('totalText').innerText = total.toLocaleString('id-ID');
        }
    </script>

</body>
</html>
