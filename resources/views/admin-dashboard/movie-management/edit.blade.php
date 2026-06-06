@extends('layouts.admin')

@section('title', 'Edit Film: ' . $movie->title)
@section('header', 'Edit Film')

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

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" 
         x-data="imagePreview('{{ $movie->getRawOriginal('poster_url') ? $movie->poster_url : '' }}')">
        
        <div class="p-6 lg:p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit Informasi Film</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui detail informasi untuk film <span class="font-bold text-slate-700">"{{ $movie->title }}"</span></p>
            </div>
            <div class="text-right">
                <span class="text-xs font-medium text-slate-400">ID Film: #{{ $movie->id }}</span>
            </div>
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
                        <h3 class="text-sm font-bold text-red-800">Gagal memperbarui data:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <div class="md:col-span-1 flex flex-col items-center">
                    <label class="block text-sm font-bold text-slate-700 mb-2 self-start">Poster Film</label>
                    
                    <div class="w-full aspect-[2/3] bg-slate-100 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden relative group transition-all hover:border-[#cbdfea] shadow-inner">
                        
                        <div x-show="!imageUrl" class="flex flex-col items-center p-4 text-center">
                            <svg class="w-12 h-12 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs font-bold text-slate-600">Unggah Poster</span>
                        </div>

                        <template x-if="imageUrl">
                            <img :src="imageUrl" class="w-full h-full object-cover shadow-lg" alt="Preview poster">
                        </template>

                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-opacity duration-300">
                            <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            </svg>
                            <span class="text-xs text-[#344152] font-bold bg-[#cbdfea] px-3 py-1.5 rounded-lg shadow-lg">Ganti Poster</span>
                        </div>

                        <input 
                            type="file" 
                            name="poster_url" 
                            @change="fileChosen"
                            accept="image/*" 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        >
                    </div>
                    <p class="mt-3 text-[10px] text-slate-400 text-center italic">Biarkan kosong jika tidak ingin mengubah poster</p>
                </div>

                <div class="md:col-span-3 space-y-5">
                    
                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-1.5">Judul Film <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title', $movie->title) }}" 
                            required
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
                                value="{{ old('genre', $movie->genre) }}" 
                                required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                            >
                        </div>

                        <div>
                            <label for="duration_minutes" class="block text-sm font-bold text-slate-700 mb-1.5">Durasi (Menit) <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                name="duration_minutes" 
                                id="duration_minutes" 
                                value="{{ old('duration_minutes', $movie->duration_minutes) }}" 
                                required
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
                                @php $ratings = ['SU', '13+', '17+', '21+']; @endphp
                                @foreach($ratings as $rating)
                                    <option value="{{ $rating }}" {{ old('rating_age', $movie->rating_age) == $rating ? 'selected' : '' }}>
                                        {{ $rating }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-1.5">Sinopsis / Deskripsi</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="6" 
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                        >{{ old('description', $movie->description) }}</textarea>
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.movies.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors text-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#cbdfea] hover:bg-[#b5cce3] text-[#344152] font-bold shadow-lg transition-all text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function imagePreview(initialUrl) {
        return {
            imageUrl: initialUrl,
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