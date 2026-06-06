@extends('layouts.user')

@section('title', 'Pembayaran – TiketBioskop')

@section('content')
<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(200, 194, 188, 0.3);
    }
</style>

<div class="bg-[#FAF3E0] min-h-screen pb-20">
    <main class="max-w-4xl mx-auto px-6 py-10">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs font-bold text-[#4B3935]/50 mb-8">
            <a href="{{ route('landing') }}" class="hover:text-[#4B3935] transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            <span class="text-[#4B3935]">Pembayaran</span>
        </div>

        {{-- Page Header --}}
        <div class="mb-10">
            <h2 class="font-baloo text-3xl font-extrabold text-[#4B3935]">Pembayaran</h2>
            <p class="text-sm mt-1 text-[#4B3935]/70">Selesaikan pembayaran untuk menyelesaikan pemesanan tiket.</p>
        </div>

        <div class="glass-panel rounded-2xl p-6 sm:p-10 shadow-sm space-y-8">

            {{-- Top Status --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-[#CBDFEA]/20 p-6 rounded-xl border border-[#CBDFEA]/30">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-[#708090]">Kode Booking</span>
                    <h2 class="text-xl font-extrabold text-[#4B3935]">{{ $transaction->transaction_code }}</h2>
                </div>
                <div class="text-left sm:text-right">
                    <span class="text-[10px] font-black uppercase tracking-widest text-[#708090]">Total Tagihan</span>
                    <h2 class="text-2xl font-black text-[#4B3935]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h2>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">

                {{-- Payment Instructions --}}
                <div class="space-y-6">
                    <h3 class="font-extrabold text-lg text-[#4B3935]">Petunjuk Pembayaran</h3>

                    @if(in_array($paymentMethod, ['gopay', 'ovo', 'dana']))
                        <div class="space-y-4 text-sm">
                            <p class="text-[#708090] font-medium">Langkah pembayaran menggunakan <span class="font-bold uppercase text-[#4B3935]">{{ $paymentMethod }}</span>:</p>
                            <ol class="list-decimal list-inside space-y-2 text-xs text-[#708090] font-medium">
                                <li>Pindai QR Code di sebelah kanan menggunakan aplikasi Anda.</li>
                                <li>Periksa kembali nominal pembayaran sebesar <span class="font-bold text-[#4B3935]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>.</li>
                                <li>Masukkan PIN keamanan aplikasi Anda.</li>
                                <li>Tunggu hingga sistem kami menerima notifikasi sukses.</li>
                            </ol>
                        </div>
                    @elseif(in_array($paymentMethod, ['bca_va', 'mandiri_va', 'bni_va']))
                        <div class="space-y-4 text-sm">
                            <p class="text-[#708090] font-medium">Nomor Virtual Account <span class="font-bold uppercase text-[#4B3935]">{{ str_replace('_', ' ', $paymentMethod) }}</span>:</p>
                            <div class="flex items-center gap-3 bg-white border border-[#C8C2BC]/30 p-3.5 rounded-xl justify-between">
                                <span class="font-mono font-black text-[#4B3935] text-lg tracking-wider">8806{{ rand(10000000, 99999999) }}</span>
                                <button type="button" class="text-xs font-bold text-[#708090] hover:text-[#4B3935] bg-[#FAF3E0] hover:bg-[#CBDFEA]/30 px-3 py-1.5 rounded-lg border border-[#C8C2BC]/30 transition-colors" onclick="alert('Nomor VA disalin!')">Salin</button>
                            </div>
                            <ol class="list-decimal list-inside space-y-2 text-xs text-[#708090] font-medium pt-2">
                                <li>Buka aplikasi m-banking atau internet banking Anda.</li>
                                <li>Pilih menu <span class="font-semibold text-[#4B3935]">Transfer</span> &gt; <span class="font-semibold text-[#4B3935]">Virtual Account</span>.</li>
                                <li>Masukkan nomor Virtual Account yang tertera di atas.</li>
                                <li>Pastikan detail nama adalah <span class="font-semibold text-[#4B3935]">Tiket Bioskop - {{ auth()->user()->name ?? 'Guest User' }}</span>.</li>
                                <li>Masukkan PIN Anda dan simulasikan transaksi lunas.</li>
                            </ol>
                        </div>
                    @elseif($paymentMethod === 'credit_card')
                        <div class="space-y-4">
                            <p class="text-[#708090] font-medium text-sm">Masukkan Informasi Kartu Kredit/Debit:</p>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-wider text-[#708090] mb-1">Nomor Kartu</label>
                                    <input type="text" disabled placeholder="4111 2222 3333 4444" class="w-full p-2.5 rounded-xl border border-[#C8C2BC]/30 bg-[#FAF3E0]/50 text-xs font-mono text-[#4B3935]">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-wider text-[#708090] mb-1">Masa Berlaku</label>
                                        <input type="text" disabled placeholder="12 / 29" class="w-full p-2.5 rounded-xl border border-[#C8C2BC]/30 bg-[#FAF3E0]/50 text-xs font-mono text-center text-[#4B3935]">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-wider text-[#708090] mb-1">CVV</label>
                                        <input type="password" disabled placeholder="***" class="w-full p-2.5 rounded-xl border border-[#C8C2BC]/30 bg-[#FAF3E0]/50 text-xs font-mono text-center text-[#4B3935]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- QR Code / Card Illustration --}}
                <div class="flex flex-col items-center justify-center p-6 bg-[#CBDFEA]/10 rounded-xl border border-[#CBDFEA]/20">
                    @if(in_array($paymentMethod, ['gopay', 'ovo', 'dana']))
                        <div class="p-3 bg-white rounded-2xl w-44 h-44 shadow-md border border-[#C8C2BC]/20 flex items-center justify-center mb-4">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Pembayaran%20Berhasil" alt="QR Code Pembayaran Berhasil" class="w-full h-full object-contain">
                        </div>
                        <p class="text-[10px] font-bold tracking-widest text-[#708090] uppercase">Pindai QR Untuk Membayar</p>
                    @else
                        <div class="w-full max-w-[200px] h-32 rounded-2xl bg-gradient-to-tr from-[#4B3935] to-[#2c1e1a] shadow-lg p-5 flex flex-col justify-between text-[#FAF3E0] mb-4 border border-[#4B3935]">
                            <div class="flex justify-between items-start">
                                <span class="font-extrabold text-sm uppercase tracking-widest">{{ $paymentMethod }}</span>
                                <div class="w-6 h-6 rounded bg-yellow-400/80"></div>
                            </div>
                            <div>
                                <p class="text-[10px] font-mono tracking-widest">**** **** **** {{ rand(1000, 9999) }}</p>
                                <p class="text-[8px] font-bold tracking-wider mt-1 uppercase">{{ auth()->user()->name ?? 'GUEST USER' }}</p>
                            </div>
                        </div>
                        <p class="text-[10px] font-bold tracking-widest text-[#708090] uppercase">Simulasi {{ strtoupper(str_replace('_', ' ', $paymentMethod)) }}</p>
                    @endif
                </div>
            </div>

            {{-- Bottom Button --}}
            <div class="pt-8 border-t border-[#C8C2BC]/20 flex flex-col items-center gap-4">
                {{-- Timer --}}
                <div class="flex items-center gap-2 text-xs font-semibold text-[#708090]">
                    <svg class="w-4 h-4 text-amber-500 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Selesaikan pembayaran dalam waktu <span id="timer" class="font-bold text-[#4B3935]">14:59</span></span>
                </div>

                <form action="{{ route('payment.simulate', $transaction) }}" method="POST" class="w-full max-w-sm">
                    @csrf
                    <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                    <button
                        type="submit"
                        class="w-full bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] font-extrabold py-3.5 px-6 rounded-xl text-center shadow-md transition-all flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Simulasikan Pembayaran Sukses</span>
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
    let time = 899;
    const timerEl = document.getElementById('timer');

    setInterval(() => {
        if (time <= 0) return;
        time--;
        const mins = Math.floor(time / 60);
        const secs = time % 60;
        timerEl.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }, 1000);
</script>
@endsection
