@extends('layouts.admin')

@section('title', 'Lokasi')
@section('header', 'Lokasi')

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

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Lokasi</h1>
        
        <div class="flex gap-2 w-full sm:w-auto">
            <form action="{{ route('admin.locations.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                <input 
                    type="text" 
                    name="search"
                    placeholder="Cari nama cabang, kota..." 
                    value="{{ request('search') }}"
                    class="border border-slate-300 px-4 py-2 rounded-xl text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                />
                <button type="submit" class="bg-[#344152] hover:bg-[#475569] text-white font-semibold py-2 px-4 rounded-xl transition-colors text-sm shadow-sm">
                    Cari
                </button>
            </form>
            
            <a href="{{ route('admin.locations.create') }}" class="bg-[#cbdfea] hover:bg-[#b5cce3] text-[#344152] font-bold py-2 px-4 rounded-xl transition-colors shadow-sm text-sm whitespace-nowrap flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Lokasi
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 table-auto">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-20">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Cabang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kota</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat Lengkap</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($locations as $index => $location)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 font-medium">
                                {{ $locations->firstItem() + $index }}
                            </td>
                            
                            <td class="px-6 py-4 text-sm text-slate-900 font-bold">
                                {{ $location->name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-[#cbdfea]/40 text-[#344152] border border-[#cbdfea]">
                                    {{ $location->city }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $location->address }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.locations.edit', $location->id) }}" class="text-slate-600 bg-slate-100 hover:bg-[#cbdfea] hover:text-[#344152] p-2 rounded-lg transition-colors shadow-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi {{ $location->name }}? Semua studio dan jadwal terkait di cabang ini juga akan ikut terhapus!');" class="inline-block">
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
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <p class="text-slate-500 font-medium">Belum ada data lokasi.</p>
                                    <p class="text-slate-400 text-sm mt-1">Klik "Tambah Lokasi" untuk mendaftarkan cabang bioskop baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($locations->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $locations->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection