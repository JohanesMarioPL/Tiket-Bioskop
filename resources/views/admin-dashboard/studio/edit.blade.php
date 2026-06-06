@extends('layouts.admin')

@section('title', 'Edit Studio')
@section('header', 'Edit Data Studio')

@section('content')
<div class="max-w-full mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('admin.studio.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Studio
        </a>
    </div>

    <div class="mb-6 flex gap-4 p-4 text-sm text-yellow-800 rounded-xl bg-yellow-50 border border-yellow-200">
        <svg class="flex-shrink-0 w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <div>
            <span class="font-bold block mb-1">Informasi Pengeditan Studio</span>
            Untuk menjaga informasi data kursi dan riwayat transaksi tiket, <strong>Tipe Studio</strong> dan <strong>Kapasitas</strong> tidak dapat diubah.
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xl font-bold text-slate-800">Edit Informasi Studio</h2>
            <p class="text-sm text-slate-500 mt-1">Anda hanya dapat mengubah lokasi dan nama studio.</p>
        </div>

        <form action="{{ route('admin.studio.update', $studio->id) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="location_id" class="block text-sm font-bold text-slate-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                    <select id="location_id" name="location_id" required class="w-full border @error('location_id') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] bg-white transition-shadow shadow-sm cursor-pointer">
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id', $studio->location_id) == $location->id ? 'selected' : '' }}>
                                {{ $location->name }} - {{ $location->city }}
                            </option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="studio_name" class="block text-sm font-bold text-slate-700 mb-2">Nama Studio <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="studio_name" 
                        name="studio_name" 
                        value="{{ old('studio_name', $studio->studio_name) }}"
                        required 
                        class="w-full border @error('studio_name') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                    @error('studio_name')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="studio_type" class="block text-sm font-bold text-slate-700 mb-2">Tipe Studio </label>
                    <input 
                        type="text" 
                        value="{{ $studio->studio_type }}"
                        disabled 
                        class="w-full border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed px-4 py-3 rounded-xl text-sm shadow-sm"
                    >
                </div>

                <div class="md:col-span-2">
                    <label for="capacity" class="block text-sm font-bold text-slate-700 mb-2">Kapasitas Kursi </label>
                    <div class="relative w-full md:w-1/2">
                        <input 
                            type="number" 
                            value="{{ $studio->capacity }}"
                            disabled 
                            class="w-full border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed px-4 py-3 pr-20 rounded-xl text-sm shadow-sm"
                        >
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.studio.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#344152] hover:bg-[#475569] rounded-xl transition-colors shadow-sm flex items-center">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection