@extends('layouts.admin')

@section('title', 'Detail Transaksi: #' . $transaction->transaction_code)
@section('header', 'Detail Transaksi')

@section('content')
<div class="w-full">
    
    <div class="mb-6">
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-[#cbdfea] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Transaksi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Detail Tiket & Kursi</h2>
                        <p class="text-xs text-slate-500 mt-1">Daftar kursi yang dipesan untuk transaksi ini</p>
                    </div>
                    <span class="text-xs font-mono font-bold bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg border border-slate-200">
                        {{ $transaction->tickets->count() }} Tiket
                    </span>
                </div>

                <div class="p-6 divide-y divide-slate-100">
                    @foreach($transaction->tickets as $ticket)
                        <div class="py-4 flex justify-between items-center first:pt-0 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#cbdfea]/30 text-[#344152] flex items-center justify-center font-bold text-lg border border-[#cbdfea]">
                                    {{-- Panggil langsung nama relasi barunya: reservation --}}
                                    {{ $ticket->reservation->seat->seat_number ?? '-' }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">
                                        Nomor Kursi: {{ $ticket->reservation->seat->seat_number ?? 'Belum Memilih' }}
                                    </h4>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        Tipe Tiket: {{ Str::upper($ticket->ticket_type) }}
                                    </p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-slate-800">
                                Rp {{ number_format($ticket->final_price, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800">Informasi Film & Jadwal</h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-24 h-36 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200 shadow-sm">
                            @if($transaction->tickets->first()->schedule->movie->poster_url ?? false)
                                <img src="{{ $transaction->tickets->first()->schedule->movie->poster_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">No Image</div>
                            @endif
                        </div>
                        <div class="space-y-3 flex-1">
                            <h3 class="text-xl font-bold text-slate-800">{{ $transaction->tickets->first()->schedule->movie->title ?? 'Film Tidak Diketahui' }}</h3>
                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div>
                                    <span class="text-xs text-slate-400 block">Studio</span>
                                    <span class="text-sm font-bold text-slate-700">
                                        {{ $transaction->tickets->first()->schedule->studio->studio_name ?? 'Studio -' }}
                                        ({{ $transaction->tickets->first()->schedule->studio->studio_type ?? '-' }})
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-slate-400 block">Waktu Tayang</span>
                                    <span class="text-sm font-bold text-slate-700">
                                        {{ isset($transaction->tickets->first()->schedule->start_time) ? \Carbon\Carbon::parse($transaction->tickets->first()->schedule->start_time)->translatedFormat('d M Y - H:i') : '-' }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800">Status Pembayaran</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">Status Saat Ini</span>
                        @if($transaction->status === 'success')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-800 border border-green-200">
                                Lunas / Success
                            </span>
                        @elseif($transaction->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-800 border border-yellow-200">
                                Menunggu / Pending
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-800 border border-red-200">
                                Batal / Failed
                            </span>
                        @endif
                    </div>

                    @if($transaction->status === 'pending')
                        <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="success">
                                <button type="submit" class="w-full bg-[#cbdfea] hover:bg-[#b5cce3] text-[#344152] font-bold py-2.5 rounded-xl transition-all text-sm shadow-md">
                                    Konfirmasi Lunas
                                </button>
                            </form>
                            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="failed">
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-500 hover:text-white text-red-600 font-semibold py-2.5 rounded-xl transition-all text-sm">
                                    Batalkan Transaksi
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800">Rincian Tagihan</h2>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Harga Tiket (x{{ $transaction->tickets->count() }})</span>
                        <span class="font-medium text-slate-800">Rp {{ number_format($transaction->total_amount - $transaction->service_fee - $transaction->tax + $transaction->discount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Biaya Layanan</span>
                        <span class="font-medium text-slate-800">Rp {{ number_format($transaction->service_fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Pajak (10%)</span>
                        <span class="font-medium text-slate-800">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                    </div>
                    @if($transaction->discount > 0)
                        <div class="flex justify-between text-sm text-green-600 font-medium">
                            <span>Diskon</span>
                            <span>-Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center pt-4 border-t border-dashed border-slate-200">
                        <span class="text-base font-bold text-slate-800">Total Akhir</span>
                        <span class="text-lg font-extrabold text-[#344152]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection