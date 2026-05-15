@extends('layouts.admin')

@section('title', 'Tambah Film Baru')
@section('header', 'Tambah Film')

@section('content')
<div class="w-full">
    
    <div class="mb-6">
        <a href="{{ route('admin.movies.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-[#cbdfea] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Film
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" x-data="imagePreview()">
        <div class="p-6 lg:p-8 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-800">Penambahan Film Baru</h2>
            <p class="text-sm text-slate-500 mt-1">Isi semua detail informasi di bawah ini untuk mendaftarkan film baru ke dalam sistem.</p>
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

        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1 flex flex-col items-center">
                    <label class="block text-sm font-bold text-slate-700 mb-2 self-start">Poster Film</label>
                    
                    <div class="w-full aspect-[2/3] bg-slate-100 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden relative group transition-all hover:border-[#cbdfea]">
                        <div x-show="!imageUrl" class="flex flex-col items-center p-4 text-center">
                            <svg class="w-12 h-12 text-slate-400 mb-3 group-hover:text-[#cbdfea] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs font-bold text-slate-600">Pilih Gambar Poster</span>
                            <span class="text-[10px] text-slate-400 mt-1">Rekomendasi rasio 2:3 (Portrait)</span>
                        </div>

                        <template x-if="imageUrl">
                            <img :src="imageUrl" class="w-full h-full object-cover" alt="Preview poster">
                        </template>

                        <div x-show="imageUrl" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                            <span class="text-xs text-[#344152] font-bold bg-[#cbdfea] px-3 py-1.5 rounded-lg shadow-lg">Ganti Poster</span>
                        </div>

                        <input 
                            type="file" 
                            name="poster_url" 
                            @change="fileChosen"
                            accept="image/*" 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        >
                    </div>
                </div>

                <div class="md:col-span-2 space-y-5">
                    
                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-1.5">Judul Film <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title') }}" 
                            required
                            placeholder="Contoh: Sang Pengadil, Avengers: Secret Wars"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                        >
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="genre" class="block text-sm font-bold text-slate-700 mb-1.5">Genre <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="genre" 
                                id="genre" 
                                value="{{ old('genre') }}" 
                                required
                                placeholder="Contoh: Action, Horor"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                            >
                        </div>

                        <div>
                            <label for="duration_minutes" class="block text-sm font-bold text-slate-700 mb-1.5">Durasi (Menit) <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                name="duration_minutes" 
                                id="duration_minutes" 
                                value="{{ old('duration_minutes') }}" 
                                min="1"
                                required
                                placeholder="Contoh: 120"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                            >
                        </div>

                        <div>
                            <label for="rating_age" class="block text-sm font-bold text-slate-700 mb-1.5">Rating Usia <span class="text-red-500">*</span></label>
                            <select 
                                name="rating_age" 
                                id="rating_age" 
                                required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm bg-white"
                            >
                                <option value="" disabled selected>Pilih Rating</option>
                                <option value="SU" {{ old('rating_age') == 'SU' ? 'selected' : '' }}>SU (Semua Umur)</option>
                                <option value="13+" {{ old('rating_age') == '13+' ? 'selected' : '' }}>13+ (Remaja)</option>
                                <option value="17+" {{ old('rating_age') == '17+' ? 'selected' : '' }}>17+ (Dewasa)</option>
                                <option value="21+" {{ old('rating_age') == '21+' ? 'selected' : '' }}>21+ (Khusus Dewasa)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-1.5">Sinopsis / Deskripsi</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="5" 
                            placeholder="Tuliskan sinopsis singkat mengenai alur cerita film..."
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                        >{{ old('description') }}</textarea>
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.movies.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition-colors text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#cbdfea] hover:bg-[#b5cce3] text-[#344152] font-bold shadow-md transition-all text-sm">
                    Simpan Film
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function imagePreview() {
        return {
            imageUrl: '',
            fileChosen(event) {
                const files = event.target.files;
                if (files.length === 0) return;
                
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageUrl = e.target.result;
                };
                reader.readAsDataURL(files[0]);
            }
        }
    }
</script>
@endsection