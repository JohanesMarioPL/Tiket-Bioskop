@extends('layouts.admin')

@section('title', 'Edit Jadwal Tayang')
@section('header', 'Edit Jadwal Tayang')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('admin.showtimes.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Jadwal
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 flex items-center p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 me-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>
            <div>
                <span class="font-bold">Gagal Memperbarui!</span> {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xl font-bold text-slate-800">Edit Jadwal Tayang</h2>
            <p class="text-sm text-slate-500 mt-1">Ubah film, studio, atau waktu tayang.</p>
        </div>

        <form action="{{ route('admin.showtimes.update', $schedule->id) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="movie_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Film <span class="text-red-500">*</span></label>
                <select id="movie_id" name="movie_id" required class="w-full border @error('movie_id') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] bg-white transition-shadow shadow-sm cursor-pointer">
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" {{ old('movie_id', $schedule->movie_id) == $movie->id ? 'selected' : '' }}>
                            {{ $movie->title }} ({{ $movie->duration_minutes }} Menit) - Rating: {{ $movie->rating_age }}
                        </option>
                    @endforeach
                </select>
                @error('movie_id')
                    <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="studio_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Studio & Lokasi <span class="text-red-500">*</span></label>
                <select id="studio_id" name="studio_id" required class="w-full border @error('studio_id') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] bg-white transition-shadow shadow-sm cursor-pointer">
                    @php
                        $groupedStudios = $studios->groupBy('location_id');
                    @endphp

                    @foreach($groupedStudios as $locationId => $studioGroup)
                        @php $lokasi = $studioGroup->first()->location; @endphp
                        <optgroup label="{{ $lokasi->name }} ({{ $lokasi->city }})">
                            @foreach($studioGroup as $studio)
                                <option value="{{ $studio->id }}" {{ old('studio_id', $schedule->studio_id) == $studio->id ? 'selected' : '' }}>
                                    {{ $studio->studio_name }} - {{ $studio->studio_type }} (Kapasitas: {{ $studio->capacity }})
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('studio_id')
                    <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_time" class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Jam Tayang <span class="text-red-500">*</span></label>
                    <input 
                        type="datetime-local" 
                        id="start_time" 
                        name="start_time" 
                        {{-- Format datetime-local Laravel butuh format Y-m-d\TH:i --}}
                        value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d\TH:i')) }}"
                        required 
                        class="w-full border @error('start_time') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                    @error('start_time')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="base_price" class="block text-sm font-bold text-slate-700 mb-2">Harga Tiket (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="base_price" 
                            name="base_price" 
                            min="20000"
                            step="1000"
                            placeholder="Rp 50000"
                            value="{{ old('base_price', (int)$schedule->base_price) }}"
                            required 
                            class="w-full border @error('base_price') border-red-500 @else border-slate-300 @enderror px-4 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                        >
                    </div>
                    @error('base_price')
                        <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.showtimes.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#344152] hover:bg-[#475569] rounded-xl transition-colors shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection