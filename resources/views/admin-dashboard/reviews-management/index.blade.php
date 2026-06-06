@extends('layouts.admin')

@section('title', 'Ulasan')
@section('header', 'Ulasan Penonton')

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
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Ulasan Penonton</h1>
        
        <div class="flex gap-2 w-full sm:w-auto">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                <input 
                    type="text" 
                    name="search"
                    placeholder="Cari pengulas, judul film..." 
                    value="{{ request('search') }}"
                    class="border border-slate-300 px-4 py-2 rounded-xl text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                />
                <button type="submit" class="bg-[#344152] hover:bg-[#475569] text-white font-semibold py-2 px-4 rounded-xl transition-colors text-sm shadow-sm">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 table-auto">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-20">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Film</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-36">Rating</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Komentar</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($reviews as $index => $review)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 font-medium">
                                {{ $reviews->firstItem() + $index }}
                            </td>
                            
                            <td class="px-6 py-4 text-sm text-slate-900 font-bold">
                                {{ $review->user->name ?? 'Pengguna Tidak Dikenal' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                {{ $review->movie->title ?? 'Film Telah Dihapus' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{-- PERUBAHAN DI BARIS BAWAH INI: Ganti warna bintang dari #cbdfea menjadi amber-400 (kuning emas) --}}
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="text-xs font-bold text-slate-500 ml-1">({{ $review->rating }}/5)</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-500 max-w-md">
                                {{ $review->comment ?? '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini? Tindakan moderasi ini tidak dapat dibatalkan.');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 bg-red-50 hover:bg-red-500 hover:text-white p-2 rounded-lg transition-colors shadow-sm" title="Hapus Ulasan (Moderasi)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <p class="text-slate-500 font-medium">Belum ada ulasan masuk.</p>
                                    <p class="text-slate-400 text-sm mt-1">Ulasan dari pengguna yang dikirim via halaman utama bioskop akan tampil di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reviews->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $reviews->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection