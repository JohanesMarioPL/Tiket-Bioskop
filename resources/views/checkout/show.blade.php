@extends('layouts.user')

@section('title', 'Ringkasan Pesanan – ' . $schedule->movie->title)

@section('content')
<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(200, 194, 188, 0.3);
    }

    .payment-card {
        border: 2px solid transparent;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: var(--blue);
    }

    .payment-card.selected {
        border-color: var(--brown);
        background-color: white;
        box-shadow: 0 10px 25px rgba(75, 57, 53, 0.1);
    }

    .payment-card.selected .check-circle {
        background-color: var(--brown);
        border-color: var(--brown);
    }

    .payment-card.selected .check-icon {
        opacity: 1;
    }
</style>

<div class="bg-[#FAF3E0] min-h-screen pb-20">
    <main class="max-w-6xl mx-auto px-6 py-10">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs font-bold text-[#4B3935]/50 mb-8">
            <a href="{{ route('movies.show', $schedule->movie_id) }}" class="hover:text-[#4B3935] transition-colors">{{ $schedule->movie->title }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('booking.show', $schedule) }}?seat_ids={{ $seatIdsStr }}" class="hover:text-[#4B3935] transition-colors">Pilih Kursi</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            <span class="text-[#4B3935]">Ringkasan Pesanan</span>
        </div>

        {{-- Page Header --}}
        <div class="mb-10">
            <h2 class="font-baloo text-3xl font-extrabold text-[#4B3935]">Ringkasan Pesanan</h2>
            <p class="text-sm mt-1 text-[#4B3935]/70">Periksa detail pesanan dan pilih metode pembayaran.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Side: Payment Method Selection --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-panel rounded-2xl p-6 sm:p-8 shadow-sm">
                    <h3 class="text-lg font-extrabold text-[#4B3935] mb-1">Metode Pembayaran</h3>
                    <p class="text-xs text-[#708090] mb-8">Pilih salah satu metode pembayaran di bawah ini.</p>

                    <form action="{{ route('checkout.store', $schedule) }}" method="POST" id="payment-form">
                        @csrf
                        <input type="hidden" name="seat_ids" value="{{ $seatIdsStr }}">
                        <input type="hidden" name="payment_method" id="selected-payment-method" value="">

                        {{-- E-Wallet --}}
                        <div class="mb-8">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-[#708090] mb-4">E-Wallet</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="payment-card p-4 rounded-xl border-2 border-[#C8C2BC]/30 bg-white/50 flex justify-between items-center gap-3" onclick="selectPayment('gopay')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center font-black text-sm text-blue-600">GP</div>
                                        <div>
                                            <p class="font-extrabold text-[#4B3935] text-sm">GoPay</p>
                                            <p class="text-[10px] text-[#708090] font-medium">Instan & Mudah</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-[#C8C2BC] flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-[#FAF3E0] opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <div class="payment-card p-4 rounded-xl border-2 border-[#C8C2BC]/30 bg-white/50 flex justify-between items-center gap-3" onclick="selectPayment('ovo')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center font-black text-sm text-purple-600">OV</div>
                                        <div>
                                            <p class="font-extrabold text-[#4B3935] text-sm">OVO</p>
                                            <p class="text-[10px] text-[#708090] font-medium">Potongan Cashback</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-[#C8C2BC] flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-[#FAF3E0] opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <div class="payment-card p-4 rounded-xl border-2 border-[#C8C2BC]/30 bg-white/50 flex justify-between items-center gap-3" onclick="selectPayment('dana')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center font-black text-sm text-sky-600">DN</div>
                                        <div>
                                            <p class="font-extrabold text-[#4B3935] text-sm">DANA</p>
                                            <p class="text-[10px] text-[#708090] font-medium">Praktis & Aman</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-[#C8C2BC] flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-[#FAF3E0] opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Virtual Account --}}
                        <div class="mb-8">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-[#708090] mb-4">Virtual Account (VA)</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="payment-card p-4 rounded-xl border-2 border-[#C8C2BC]/30 bg-white/50 flex justify-between items-center gap-3" onclick="selectPayment('bca_va')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-100/50 flex items-center justify-center font-black text-sm text-blue-900">BCA</div>
                                        <div>
                                            <p class="font-extrabold text-[#4B3935] text-sm">BCA VA</p>
                                            <p class="text-[10px] text-[#708090] font-medium">BCA Virtual Account</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-[#C8C2BC] flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-[#FAF3E0] opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <div class="payment-card p-4 rounded-xl border-2 border-[#C8C2BC]/30 bg-white/50 flex justify-between items-center gap-3" onclick="selectPayment('mandiri_va')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-yellow-100/50 flex items-center justify-center font-black text-sm text-yellow-700">MDR</div>
                                        <div>
                                            <p class="font-extrabold text-[#4B3935] text-sm">Mandiri VA</p>
                                            <p class="text-[10px] text-[#708090] font-medium">Transfer Otomatis</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-[#C8C2BC] flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-[#FAF3E0] opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                                <div class="payment-card p-4 rounded-xl border-2 border-[#C8C2BC]/30 bg-white/50 flex justify-between items-center gap-3" onclick="selectPayment('bni_va')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center font-black text-sm text-orange-600">BNI</div>
                                        <div>
                                            <p class="font-extrabold text-[#4B3935] text-sm">BNI VA</p>
                                            <p class="text-[10px] text-[#708090] font-medium">Sistem Pembayaran BNI</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-[#C8C2BC] flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-[#FAF3E0] opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kartu Kredit --}}
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-[#708090] mb-4">Kartu Kredit</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="payment-card p-4 rounded-xl border-2 border-[#C8C2BC]/30 bg-white/50 flex justify-between items-center gap-3" onclick="selectPayment('credit_card')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center font-black text-sm text-emerald-600">CC</div>
                                        <div>
                                            <p class="font-extrabold text-[#4B3935] text-sm">Kartu Kredit/Debit</p>
                                            <p class="text-[10px] text-[#708090] font-medium">Visa, Mastercard, JCB</p>
                                        </div>
                                    </div>
                                    <div class="check-circle w-5 h-5 rounded-full border-2 border-[#C8C2BC] flex items-center justify-center transition-all">
                                        <div class="check-icon w-2 h-2 rounded-full bg-[#FAF3E0] opacity-0 transition-opacity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right Side: Order Summary Sidebar --}}
            <div>
                <div class="glass-panel rounded-2xl p-6 shadow-sm space-y-6 sticky top-6">

                    {{-- Movie Info --}}
                    <div class="flex gap-4">
                        <div class="w-16 h-22 bg-gradient-to-br from-[#CBDFEA] to-[#C8C2BC] rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                            @if($schedule->movie->poster_url)
                                <img src="{{ $schedule->movie->poster_url }}" class="w-full h-full object-cover" alt="{{ $schedule->movie->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-white/60 font-bold">Poster</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base text-[#4B3935] leading-tight">{{ $schedule->movie->title }}</h3>
                            <p class="text-[10px] font-bold text-[#708090] uppercase mt-1">{{ $schedule->studio->studio_name }} ({{ $schedule->studio->studio_type }})</p>
                            <p class="text-[10px] font-bold text-[#708090]/60 uppercase mt-0.5">{{ $schedule->studio->location->name }}</p>
                        </div>
                    </div>

                    {{-- Show Details --}}
                    <div class="border-t border-[#C8C2BC]/20 pt-4 space-y-3 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-[#708090] font-medium">Waktu Tayang</span>
                            <span class="font-bold text-[#4B3935]">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('d M Y - H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="text-[#708090] font-medium">Nomor Kursi</span>
                            <span class="font-extrabold text-[#4B3935] text-right max-w-[150px] break-words">
                                {{ $seats->pluck('seat_number')->sort()->implode(', ') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#708090] font-medium">Jumlah Tiket</span>
                            <span class="font-bold text-[#4B3935]">{{ $quantity }} Tiket</span>
                        </div>
                    </div>

                    {{-- Price Breakdown (Decorator Pattern) --}}
                    <div class="border-t border-[#C8C2BC]/20 pt-4 space-y-2.5 text-xs">
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#708090] mb-3">Rincian Harga</p>
                        @foreach($breakdown as $item)
                            <div class="flex justify-between items-center">
                                <span class="text-[#708090] font-medium flex items-center gap-1.5">
                                    @if($item['type'] === 'base')
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#708090] inline-block"></span>
                                    @elseif($item['type'] === 'add')
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                                    @endif
                                    {{ $item['label'] }}
                                </span>
                                <span class="font-bold {{ $item['type'] === 'subtract' ? 'text-emerald-600' : 'text-[#4B3935]' }}">
                                    {{ $item['type'] === 'subtract' ? '-' : '' }}Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach

                        <div class="flex justify-between items-center pt-4 border-t border-dashed border-[#C8C2BC]/30">
                            <span class="font-bold text-[#4B3935] text-sm">Total Pembayaran</span>
                            <span class="text-xl font-black text-[#4B3935]">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button
                        type="button"
                        id="pay-submit-btn"
                        disabled
                        onclick="submitForm()"
                        class="w-full bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] font-extrabold py-3.5 px-6 rounded-xl text-center shadow-md transition-all disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <span>Konfirmasi & Bayar</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function selectPayment(method) {
        document.querySelectorAll('.payment-card').forEach(card => {
            card.classList.remove('selected');
        });

        const selectedCard = event.currentTarget;
        selectedCard.classList.add('selected');

        document.getElementById('selected-payment-method').value = method;
        document.getElementById('pay-submit-btn').removeAttribute('disabled');
    }

    function submitForm() {
        document.getElementById('payment-form').submit();
    }
</script>
@endsection
