<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout – {{ $schedule->movie->title }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream:  #FAF3E0;
            --blue:   #CBDFEA;
            --gray:   #C8C2BC;
            --slate:  #344152;
            --brown:  #4B3935;
        }

        body {
            background-color: var(--cream);
            color: var(--slate);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .payment-card {
            border: 2px solid transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .payment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            border-color: var(--blue);
        }

        .payment-card.selected {
            border-color: var(--slate);
            background-color: white;
            box-shadow: 0 10px 25px rgba(52, 65, 82, 0.08);
        }

        .payment-card.selected .check-circle {
            background-color: var(--slate);
            border-color: var(--slate);
        }

        .payment-card.selected .check-icon {
            opacity: 1;
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
            <a href="{{ route('booking.show', $schedule) }}?seat_ids={{ $seatIdsStr }}" class="text-sm font-bold flex items-center gap-2 hover:opacity-80 transition-opacity" style="color: var(--cream);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Kursi
            </a>
        </div>
    </header>

    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Payment Method Selection -->
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-panel rounded-3xl p-6 sm:p-8 shadow-xl">
                    <h2 class="text-xl font-extrabold text-slate-800 mb-2">Metode Pembayaran</h2>
                    <p class="text-xs text-slate-500 mb-8">Pilih salah satu metode pembayaran di bawah ini.</p>

                    <form action="{{ route('checkout.store', $schedule) }}" method="POST" id="payment-form">
                        @csrf
                        <input type="hidden" name="seat_ids" value="{{ $seatIdsStr }}">
                        <input type="hidden" name="payment_method" id="selected-payment-method" value="">

                        <!-- Section: E-Wallet -->
                        <div class="mb-8">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">E-Wallet</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- GoPay -->
                                <div class="payment-card p-4 rounded-2xl border-2 border-slate-200 bg-white/50 cursor-pointer flex justify-between items-center gap-3" onclick="selectPayment('gopay')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center font-black text-sm text-blue-600">GP</div>
                                        <div>
                                            <p class="font-extrabold text-slate-800 text-sm">GoPay</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Instan & Mudah</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-cream opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <!-- OVO -->
                                <div class="payment-card p-4 rounded-2xl border-2 border-slate-200 bg-white/50 cursor-pointer flex justify-between items-center gap-3" onclick="selectPayment('ovo')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center font-black text-sm text-purple-600">OV</div>
                                        <div>
                                            <p class="font-extrabold text-slate-800 text-sm">OVO</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Potongan Cashback</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-cream opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <!-- Dana -->
                                <div class="payment-card p-4 rounded-2xl border-2 border-slate-200 bg-white/50 cursor-pointer flex justify-between items-center gap-3" onclick="selectPayment('dana')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center font-black text-sm text-sky-600">DN</div>
                                        <div>
                                            <p class="font-extrabold text-slate-800 text-sm">DANA</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Praktis & Aman</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-cream opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Virtual Account -->
                        <div class="mb-8">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Virtual Account (VA)</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- BCA VA -->
                                <div class="payment-card p-4 rounded-2xl border-2 border-slate-200 bg-white/50 cursor-pointer flex justify-between items-center gap-3" onclick="selectPayment('bca_va')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-100/50 flex items-center justify-center font-black text-sm text-blue-900">BCA</div>
                                        <div>
                                            <p class="font-extrabold text-slate-800 text-sm">BCA VA</p>
                                            <p class="text-[10px] text-slate-400 font-medium">BCA Virtual Account</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-cream opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <!-- Mandiri VA -->
                                <div class="payment-card p-4 rounded-2xl border-2 border-slate-200 bg-white/50 cursor-pointer flex justify-between items-center gap-3" onclick="selectPayment('mandiri_va')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-yellow-100/50 flex items-center justify-center font-black text-sm text-yellow-700">MDR</div>
                                        <div>
                                            <p class="font-extrabold text-slate-800 text-sm">Mandiri VA</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Transfer Otomatis</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-cream opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <!-- BNI VA -->
                                <div class="payment-card p-4 rounded-2xl border-2 border-slate-200 bg-white/50 cursor-pointer flex justify-between items-center gap-3" onclick="selectPayment('bni_va')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center font-black text-sm text-orange-600">BNI</div>
                                        <div>
                                            <p class="font-extrabold text-slate-800 text-sm">BNI VA</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Sistem Pembayaran BNI</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-cream opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Credit Card -->
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Kartu Kredit</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- CC -->
                                <div class="payment-card p-4 rounded-2xl border-2 border-slate-200 bg-white/50 cursor-pointer flex justify-between items-center gap-3" onclick="selectPayment('credit_card')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center font-black text-sm text-emerald-600">CC</div>
                                        <div>
                                            <p class="font-extrabold text-slate-800 text-sm">Kartu Kredit/Debit</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Visa, Mastercard, JCB</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-cream opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side: Order Summary -->
            <div>
                <div class="glass-panel rounded-3xl p-6 shadow-xl space-y-6">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-lg mb-1">{{ $schedule->movie->title }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase">{{ $schedule->studio->studio_name }} ({{ $schedule->studio->studio_type }})</p>
                        <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">{{ $schedule->studio->location->name }}</p>
                    </div>

                    <div class="border-t border-slate-200/60 pt-4 space-y-3 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Waktu Tayang</span>
                            <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('d M Y - H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="text-slate-500 font-medium">Nomor Kursi</span>
                            <span class="font-extrabold text-slate-800 text-right max-w-[150px] break-words">
                                {{ $seats->pluck('seat_number')->sort()->implode(', ') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Jumlah Tiket</span>
                            <span class="font-bold text-slate-800">{{ $quantity }} Tiket</span>
                        </div>
                    </div>


                    {{-- Decorator Pattern – Tampilkan setiap lapisan harga secara dinamis --}}
                    <div class="border-t border-slate-200/60 pt-4 space-y-2.5 text-xs">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Rincian Harga</p>
                        @foreach($breakdown as $item)
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 font-medium flex items-center gap-1">
                                    @if($item['type'] === 'base')
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 inline-block"></span>
                                    @elseif($item['type'] === 'add')
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                                    @endif
                                    {{ $item['label'] }}
                                </span>
                                <span class="font-bold {{ $item['type'] === 'subtract' ? 'text-emerald-600' : 'text-slate-800' }}">
                                    {{ $item['type'] === 'subtract' ? '-' : '' }}Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center pt-4 border-t border-dashed border-slate-200">
                            <span class="font-bold text-slate-800 text-sm">Total Pembayaran</span>
                            <span class="text-xl font-black text-slate-800">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>



                    <button 
                        type="button" 
                        id="pay-submit-btn" 
                        disabled 
                        onclick="submitForm()"
                        style="background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);"
                        class="w-full text-cream font-extrabold py-3.5 px-6 rounded-2xl text-center shadow-lg transition-all hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <span>Konfirmasi & Bayar</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </main>

    <script>
        function selectPayment(method) {
            // Remove selection class from all cards
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selection class to selected card
            const selectedCard = event.currentTarget;
            selectedCard.classList.add('selected');

            // Set hidden input value
            document.getElementById('selected-payment-method').value = method;

            // Enable pay submit button
            document.getElementById('pay-submit-btn').removeAttribute('disabled');
        }

        function submitForm() {
            document.getElementById('payment-form').submit();
        }
    </script>

</body>
</html>
