@extends('layouts.admin')

@section('title', 'Tambah Studio')
@section('header', 'Tambah Studio Baru')

@section('content')
<div class="max-w-full mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('admin.studio.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Studio
        </a>
    </div>

    <div class="mb-6 flex gap-4 p-4 text-sm text-yellow-800 rounded-xl bg-yellow-50 border border-yellow-200">
        <svg class="flex-shrink-0 w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <span class="font-bold block mb-1">Sistem Generasi Kursi Otomatis</span>
            Anda tidak perlu memasukkan kursi secara manual. Sistem akan otomatis menyusun letak dan penomoran kursi berdasarkan <strong>Tipe Studio</strong> dan <strong>Kapasitas</strong> yang Anda masukkan.
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xl font-bold text-slate-800">Informasi Studio</h2>
            <p class="text-sm text-slate-500 mt-1">Lengkapi data di bawah ini untuk menambah studio baru.</p>
        </div>

        <form action="{{ route('admin.studio.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="location_id" class="block text-sm font-bold text-slate-700 mb-2">Lokasi<span class="text-red-500">*</span></label>
                    <select id="location_id" name="location_id" required class="w-full border @error('location_id') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] bg-white transition-shadow shadow-sm cursor-pointer">
                        <option value="" disabled {{ old('location_id') ? '' : 'selected' }}>-- Pilih Lokasi Bioskop --</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
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
                        placeholder="Contoh: Studio 1, Studio 2, The Premiere"
                        value="{{ old('studio_name') }}"
                        required 
                        class="w-full border @error('studio_name') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                    @error('studio_name')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="studio_type" class="block text-sm font-bold text-slate-700 mb-2">Tipe Studio <span class="text-red-500">*</span></label>
                    <select id="studio_type" name="studio_type" required class="w-full border @error('studio_type') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] bg-white transition-shadow shadow-sm cursor-pointer">
                        <option value="" disabled {{ old('studio_type') ? '' : 'selected' }}>-- Pilih Tipe Studio --</option>
                        <optgroup label="Tipe Standar">
                            <option value="Regular 2D" {{ old('studio_type') == 'Regular 2D' ? 'selected' : '' }}>Regular 2D</option>
                            <option value="Regular 3D" {{ old('studio_type') == 'Regular 3D' ? 'selected' : '' }}>Regular 3D</option>
                        </optgroup>
                        <optgroup label="Tipe Premium">
                            <option value="Premiere" {{ old('studio_type') == 'Premiere' ? 'selected' : '' }}>Premiere</option>
                            <option value="Starium 2D" {{ old('studio_type') == 'Starium 2D' ? 'selected' : '' }}>Starium 2D</option>
                        </optgroup>
                        <optgroup label="Tipe IMAX">
                            <option value="IMAX 2D" {{ old('studio_type') == 'IMAX 2D' ? 'selected' : '' }}>IMAX 2D</option>
                            <option value="IMAX 3D" {{ old('studio_type') == 'IMAX 3D' ? 'selected' : '' }}>IMAX 3D</option>
                        </optgroup>
                    </select>
                    @error('studio_type')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="capacity" class="block text-sm font-bold text-slate-700 mb-2">Kapasitas Kursi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="capacity" 
                            name="capacity" 
                            min="10"
                            placeholder="Contoh: 50"
                            value="{{ old('capacity') }}"
                            required 
                            class="w-full border @error('capacity') border-red-500 @else border-slate-300 @enderror px-4 py-3 pr-20 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                        >
                    </div>
                    <p class="text-xs text-slate-500 mt-2 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Sistem akan membuat kursi sebanyak kapasitas yang diisi.
                    </p>
                    @error('capacity')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.studio.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#344152] hover:bg-[#475569] rounded-xl transition-colors shadow-sm flex items-center">
                    Simpan & Generate Kursi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection