<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simulasi Pembayaran – Tiket Bioskop</title>
    
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

        .qr-placeholder {
            background: radial-gradient(circle, #ffffff 0%, #f3f4f6 100%);
            border: 2px dashed var(--slate);
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
                <span class="text-2xl font-extrabold tracking-tight" style="color: var(--cream);">
                    Tiket<span style="color: var(--blue);">Bioskop</span>
                </span>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-3xl w-full mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="glass-panel rounded-3xl p-6 sm:p-10 shadow-xl space-y-8">
            
            <!-- Top Status Alert -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/60 p-6 rounded-2xl border border-slate-100 shadow-sm">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Kode Booking</span>
                    <h2 class="text-xl font-extrabold text-slate-800">{{ $transaction->transaction_code }}</h2>
                </div>
                <div class="text-left sm:text-right">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Tagihan</span>
                    <h2 class="text-2xl font-black text-slate-800">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                
                <!-- Payment Instructions -->
                <div class="space-y-6">
                    <h3 class="font-extrabold text-lg text-slate-800">Petunjuk Pembayaran</h3>
                    
                    @if(in_array($paymentMethod, ['gopay', 'ovo', 'dana']))
                        <!-- E-Wallet Instructions -->
                        <div class="space-y-4 text-sm">
                            <p class="text-slate-600 font-medium">Langkah pembayaran menggunakan <span class="font-bold uppercase text-slate-800">{{ $paymentMethod }}</span>:</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs text-slate-500 font-medium">
                                <li>Pindai QR Code di sebelah kanan menggunakan aplikasi Anda.</li>
                                <li>Periksa kembali nominal pembayaran sebesar <span class="font-bold text-slate-800">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>.</li>
                                <li>Masukkan PIN keamanan aplikasi Anda.</li>
                                <li>Tunggu hingga sistem kami menerima notifikasi sukses.</li>
                            </ol>
                        </div>
                    @elseif(in_array($paymentMethod, ['bca_va', 'mandiri_va', 'bni_va']))
                        <!-- Virtual Account Instructions -->
                        <div class="space-y-4 text-sm">
                            <p class="text-slate-600 font-medium">Nomor Virtual Account <span class="font-bold uppercase text-slate-800">{{ str_replace('_', ' ', $paymentMethod) }}</span>:</p>
                            <div class="flex items-center gap-3 bg-white border border-slate-200 p-3.5 rounded-xl justify-between">
                                <span class="font-mono font-black text-slate-800 text-lg tracking-wider">8806{{ rand(10000000, 99999999) }}</span>
                                <button type="button" class="text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg border border-slate-200" onclick="alert('Nomor VA disalin!')">Salin</button>
                            </div>
                            <ol class="list-decimal list-inside space-y-2 text-xs text-slate-500 font-medium pt-2">
                                <li>Buka aplikasi m-banking atau internet banking Anda.</li>
                                <li>Pilih menu <span class="font-semibold text-slate-700">Transfer</span> &gt; <span class="font-semibold text-slate-700">Virtual Account</span>.</li>
                                <li>Masukkan nomor Virtual Account yang tertera di atas.</li>
                                <li>Pastikan detail nama adalah <span class="font-semibold text-slate-700">Tiket Bioskop - {{ auth()->user()->name ?? 'Guest User' }}</span>.</li>
                                <li>Masukkan PIN Anda dan simulasikan transaksi lunas.</li>
                            </ol>
                        </div>
                    @elseif($paymentMethod === 'credit_card')
                        <!-- Credit Card Mockup Fields -->
                        <div class="space-y-4">
                            <p class="text-slate-600 font-medium text-sm">Masukkan Informasi Kartu Kredit/Debit:</p>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Nomor Kartu</label>
                                    <input type="text" disabled placeholder="4111 2222 3333 4444" class="w-full p-2.5 rounded-xl border border-slate-200 bg-white/40 text-xs font-mono">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Masa Berlaku</label>
                                        <input type="text" disabled placeholder="12 / 29" class="w-full p-2.5 rounded-xl border border-slate-200 bg-white/40 text-xs font-mono text-center">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">CVV</label>
                                        <input type="password" disabled placeholder="***" class="w-full p-2.5 rounded-xl border border-slate-200 bg-white/40 text-xs font-mono text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- QR Code / Card View -->
                <div class="flex flex-col items-center justify-center p-6 bg-white/40 rounded-2xl border border-slate-100 shadow-inner">
                    @if(in_array($paymentMethod, ['gopay', 'ovo', 'dana']))
                        <!-- Simulated QR Code -->
                        <div class="qr-placeholder p-4 rounded-2xl w-44 h-44 shadow-lg border border-slate-200 flex items-center justify-center mb-4">
                            <span class="text-sm font-bold text-slate-400 uppercase tracking-widest text-center">Tempat<br>QR Code</span>
                        </div>
                        <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">Pindai QR Untuk Membayar</p>
                    @else
                        <!-- VA / CC Illustration -->
                        <div class="w-full max-w-[200px] h-32 rounded-2xl bg-gradient-to-tr from-slate-800 to-slate-700 shadow-lg p-5 flex flex-col justify-between text-cream mb-4 border border-slate-600">
                            <div class="flex justify-between items-start">
                                <span class="font-extrabold text-sm uppercase tracking-widest">{{ $paymentMethod }}</span>
                                <div class="w-6 h-6 rounded bg-yellow-400/80"></div>
                            </div>
                            <div>
                                <p class="text-[10px] font-mono tracking-widest">**** **** **** {{ rand(1000, 9999) }}</p>
                                <p class="text-[8px] font-bold tracking-wider mt-1 uppercase">{{ auth()->user()->name ?? 'GUEST USER' }}</p>
                            </div>
                        </div>
                        <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">Simulasi {{ strtoupper(str_replace('_', ' ', $paymentMethod)) }}</p>
                    @endif
                </div>

            </div>

            <!-- Bottom Sim Button -->
            <div class="pt-8 border-t border-slate-200/60 flex flex-col items-center gap-4">
                <!-- Timeout Alert Mockup -->
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <svg class="w-4 h-4 text-amber-500 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Selesaikan pembayaran dalam waktu <span id="timer" class="font-bold text-slate-800">14:59</span></span>
                </div>

                <form action="{{ route('payment.simulate', $transaction) }}" method="POST" class="w-full max-w-sm">
                    @csrf
                    <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                    <button 
                        type="submit" 
                        style="background: linear-gradient(135deg, var(--brown) 0%, #2c1e1a 100%);"
                        class="w-full text-cream font-extrabold py-3.5 px-6 rounded-2xl text-center shadow-lg transition-all hover:opacity-90 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Simulasikan Pembayaran Sukses</span>
                    </button>
                </form>
            </div>

        </div>
    </main>

    <script>
        // Simple mock countdown timer
        let time = 899; // 15 mins
        const timerEl = document.getElementById('timer');
        
        setInterval(() => {
            if (time <= 0) return;
            time--;
            const mins = Math.floor(time / 60);
            const secs = time % 60;
            timerEl.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }, 1000);
    </script>

</body>
</html>
