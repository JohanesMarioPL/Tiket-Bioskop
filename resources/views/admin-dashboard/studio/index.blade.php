@extends('layouts.admin')

@section('title', 'Manajemen Studio')
@section('header', 'Manajemen Studio')

@section('content')
<div class="relative">
    
    @if(session('success'))
        <div class="mb-4 flex items-center justify-between p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <div class="flex items-center">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
            <button type="button" class="text-green-800 hover:text-green-900" onclick="this.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 flex items-center justify-between p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <div class="flex items-center">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
                <span class="font-medium">Gagal!</span> {{ session('error') }}
            </div>
            <button type="button" class="text-red-800 hover:text-red-900" onclick="this.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Studio</h1>
        
        <div class="flex gap-2 w-full sm:w-auto">
            <form action="{{ route('admin.studio.index') }}" method="GET" class="flex flex-wrap gap-2 w-full sm:w-auto items-center">
                
                <select name="location" class="border border-slate-300 px-4 py-2 rounded-xl text-sm w-full sm:w-48 focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm bg-white cursor-pointer">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location') == $loc->id ? 'selected' : '' }}>
                            {{ $loc->name }} ({{ $loc->city }})
                        </option>
                    @endforeach
                </select>

                <input 
                    type="text" 
                    name="search"
                    placeholder="Cari nama studio..." 
                    value="{{ request('search') }}"
                    class="border border-slate-300 px-4 py-2 rounded-xl text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                />
                
                <button type="submit" class="bg-[#344152] hover:bg-[#475569] text-white font-semibold py-2 px-4 rounded-xl transition-colors text-sm shadow-sm">
                    Filter
                </button>

                @if(request('search') || request('location'))
                    <a href="{{ route('admin.studio.index') }}" class="text-slate-500 hover:text-red-500 bg-slate-100 hover:bg-red-50 font-semibold py-2 px-4 rounded-xl transition-colors text-sm shadow-sm flex items-center">
                        Reset
                    </a>
                @endif
            </form>
            
            <a href="{{ route('admin.studio.create') }}" class="bg-[#cbdfea] hover:bg-[#b5cce3] text-[#344152] font-bold py-2 px-4 rounded-xl transition-colors shadow-sm text-sm whitespace-nowrap flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Studio
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 table-auto">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-48">Info Studio</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-48">Lokasi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kapasitas Kursi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($studios as $index => $studio)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 font-medium align-top">
                                {{ $studios->firstItem() + $index }}
                            </td>
                            
                            <td class="px-6 py-4 align-top">
                                <div class="text-sm text-slate-900 font-bold">{{ $studio->studio_name }}</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#344152] text-white mt-1">
                                    {{ $studio->studio_type }}
                                </span>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="text-sm font-semibold text-slate-800">{{ $studio->location->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $studio->location->city }}</div>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-bold text-slate-700">Total: {{ $studio->seats_count }} Kursi</span>
                                </div>
                                
                                <div class="flex flex-wrap gap-1.5 p-2 bg-slate-50 border border-slate-200 rounded-lg max-h-24 overflow-y-auto">
                                    @forelse($studio->seats as $seat)
                                        <span class="text-[10px] font-medium px-1.5 py-0.5 bg-white border border-slate-300 rounded text-slate-600 shadow-sm">
                                            {{ $seat->seat_number }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Belum ada kursi yang di-generate.</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium align-top">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.studio.edit', $studio->id) }}" class="text-slate-600 bg-slate-100 hover:bg-[#cbdfea] hover:text-[#344152] p-2 rounded-lg transition-colors shadow-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.studio.destroy', $studio->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $studio->studio_name }}? Seluruh data kursi akan ikut terhapus!');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 bg-red-50 hover:bg-red-500 hover:text-white p-2 rounded-lg transition-colors shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <p class="text-slate-500 font-medium">Belum ada data studio.</p>
                                    <p class="text-slate-400 text-sm mt-1">Klik "Tambah Studio" untuk mendaftarkan studio dan meng-generate kursinya.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($studios->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $studios->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection