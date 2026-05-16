@extends('layouts.admin')

@section('title', 'Tambah Lokasi Baru')
@section('header', 'Tambah Lokasi')

@section('content')
<div class="w-full">
    
    <div class="mb-6">
        <a href="{{ route('admin.locations.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-[#cbdfea] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Lokasi
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 lg:p-8 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-800">Penambahan Lokasi Baru</h2>
            <p class="text-sm text-slate-500 mt-1">Isi detail informasi di bawah ini untuk menambahkan lokasi bioskop baru ke dalam sistem.</p>
        </div>

        @if ($errors->any())
            <div class="p-6 bg-red-50 border-b border-red-100">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Periksa kembali isian Anda:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.locations.store') }}" method="POST" class="p-6 lg:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Bioskop <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        required
                        placeholder="Contoh: XXI Cinema"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                </div>

                <div>
                    <label_ for="city" class="block text-sm font-bold text-slate-700 mb-1.5">Kota <span class="text-red-500">*</span></label_>
                    <input 
                        type="text" 
                        name="city" 
                        id="city" 
                        value="{{ old('city') }}" 
                        required
                        placeholder="Contoh: Bandung"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea 
                    name="address" 
                    id="address" 
                    rows="4" 
                    required
                    placeholder="Tuliskan alamat jalan, gedung, nomor, dan detail lokasi bioskop"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                >{{ old('address') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.locations.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition-colors text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#cbdfea] hover:bg-[#b5cce3] text-[#344152] font-bold shadow-md transition-all text-sm">
                    Simpan Lokasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection