@extends('layouts.user')

@section('title', $cinema->name)

@section('content')
<div x-data="bookingFlow()" class="bg-[#FAF3E0] min-h-screen pb-20 font-baloo relative">
    <div class="max-w-4xl mx-auto px-4 md:px-10 py-6">
        
        <nav class="text-sm text-slate-500 mb-4">
            <a href="{{ route('landing') }}" class="hover:text-[#4B3935]">Beranda</a> / 
            <a href="{{ route('cinemas.index') }}" class="hover:text-[#4B3935]">Bioskop</a> / 
            <span class="text-slate-800 font-semibold">{{ $cinema->name }}</span>
        </nav>

        <div class="mb-6">
            <h1 class="text-3xl md:text-4xl font-black text-[#4B3935] uppercase tracking-wide mb-2">{{ $cinema->name }}</h1>
            <button class="inline-flex items-center gap-1.5 border border-teal-600 text-teal-700 text-xs font-bold px-4 py-1.5 rounded-full hover:bg-teal-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                Info Bioskop
            </button>
        </div>

        <div class="flex gap-2 overflow-x-auto pb-3 mb-8 scrollbar-hide">
            @php
                // Helper array untuk translate hari singkat ke Indonesia
                $dayTranslations = ['Sun'=>'Ming', 'Mon'=>'Sen', 'Tue'=>'Sel', 'Wed'=>'Rab', 'Thu'=>'Kam', 'Fri'=>'Jum', 'Sat'=>'Sab'];
            @endphp
            @foreach($dates as $date)
                @php
                    $formattedDate = $date->format('Y-m-d');
                    $isToday = $date->isToday();
                    $isSelected = $selectedDate === $formattedDate;
                    $dayName = $isToday ? 'Hari ini' : ($dayTranslations[$date->format('D')] ?? $date->format('D'));
                @endphp
                <a href="{{ route('cinemas.show', [$cinema->id, 'date' => $formattedDate]) }}" 
                   class="flex flex-col items-center justify-center min-w-[70px] py-2.5 rounded-xl border transition-all text-center
                          {{ $isSelected 
                             ? 'bg-teal-600 border-teal-600 text-white font-bold shadow-md' 
                             : 'bg-white border-[#C8C2BC]/40 text-slate-500 hover:border-slate-400 font-medium' }}">
                    <span class="text-xs opacity-80 uppercase">{{ $dayName }}</span>
                    <span class="text-base font-bold mt-0.5">{{ $date->format('d') }}</span>
                </a>
            @endforeach
        </div>

        @forelse($groupedSchedules as $studioType => $moviesInStudio)
            <div class="mb-8 space-y-6">
                <div class="inline-block bg-[#4B3935] text-[#FAF3E0] text-xs font-black px-5 py-2.5 rounded-full shadow-sm tracking-widest uppercase">
                    {{ $studioType }}
                </div>

                @foreach($moviesInStudio as $movieData)
                    @php
                        $movie = $movieData['movie'];
                        $schedules = $movieData['schedules'];
                    @endphp
                    <div class="bg-white rounded-2xl border border-[#C8C2BC]/30 shadow-sm p-5 flex flex-col md:flex-row gap-5">
                        
                        <div class="w-[110px] aspect-[3/4] bg-slate-100 rounded-xl overflow-hidden shadow-sm mx-auto md:mx-0 flex-shrink-0">
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 space-y-3">
                            <div>
                                <h3 class="text-xl font-extrabold text-[#4B3935] uppercase tracking-wide leading-tight">{{ $movie->title }}</h3>
                                <p class="text-xs font-medium text-slate-400 mt-0.5">{{ $movie->genre }}</p>
                            </div>

                            <div class="flex gap-1.5 text-[10px] font-black tracking-wider">
                                <span class="bg-amber-100 border border-amber-200 text-amber-700 px-2 py-0.5 rounded">
                                    {{ $movie->rating_age }}
                                </span>
                                <span class="bg-slate-100 border border-slate-200 text-slate-600 px-2 py-0.5 rounded">
                                    2D
                                </span>
                            </div>

                            <div class="pt-2 border-t border-dashed border-slate-200">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Pilih Jam Tayang:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($schedules as $schedule)
                                        
                                        @auth
                                            <a href="{{ route('booking.show', $schedule->id) }}" class="bg-slate-50 hover:bg-teal-50 border border-slate-200 hover:border-teal-400 text-[#4B3935] hover:text-teal-700 font-bold px-4 py-2 rounded-lg text-sm shadow-sm transition-all text-center min-w-[70px]">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                            </a>
                                        @endauth

                                        @guest
                                            <button type="button" @click="openModal('{{ route('booking.show', $schedule->id) }}')" class="bg-slate-50 hover:bg-teal-50 border border-slate-200 hover:border-teal-400 text-[#4B3935] hover:text-teal-700 font-bold px-4 py-2 rounded-lg text-sm shadow-sm transition-all text-center min-w-[70px]">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                            </button>
                                        @endguest
                                        
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-[#C8C2BC]/30 p-12 text-center text-slate-400 font-medium">
                Tidak ada jadwal penayangan film untuk tanggal terpilih di bioskop ini.
            </div>
        @endforelse

    </div>

    <div x-show="isModalOpen" 
         style="display: none;" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm px-4"
         x-transition.opacity>
         
        <div @click.away="closeModal()" 
             x-show="isModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl relative">
            
            <button @click="closeModal()" class="absolute top-5 right-5 text-slate-400 hover:text-red-500 transition-colors">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="mb-6">
                <h2 class="text-2xl md:text-3xl font-black text-[#4B3935] tracking-wide mb-1">Login Dulu, Yuk!</h2>
                <p class="text-sm font-medium text-slate-500">Masuk untuk mengamankan kursi film kamu.</p>
            </div>

            <div x-show="errorMessage" x-text="errorMessage" class="bg-red-50 text-red-600 text-sm font-bold px-4 py-3 rounded-xl mb-4 border border-red-100" style="display: none;"></div>

            <form @submit.prevent="submitLogin" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-[#4B3935] mb-1.5">Email</label>
                    <input type="email" x-model="form.email" required 
                           class="w-full bg-slate-50 border border-[#C8C2BC]/50 rounded-xl px-4 py-3 text-[#4B3935] focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 transition-all">
                    <span x-show="errors.email" x-text="errors.email[0]" class="text-red-500 text-xs font-bold mt-1 block"></span>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-[#4B3935] mb-1.5">Password</label>
                    <input type="password" x-model="form.password" required 
                           class="w-full bg-slate-50 border border-[#C8C2BC]/50 rounded-xl px-4 py-3 text-[#4B3935] focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 transition-all">
                    <span x-show="errors.password" x-text="errors.password[0]" class="text-red-500 text-xs font-bold mt-1 block"></span>
                </div>

                <div class="pt-2">
                    <button type="submit" :disabled="isLoading" 
                            class="w-full bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] font-black tracking-wider py-3.5 rounded-xl transition-all shadow-md disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!isLoading">Login & Lanjutkan Booking</span>
                        <span x-show="isLoading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Memproses...
                        </span>
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <span class="text-sm font-medium text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="text-teal-600 font-bold hover:underline">Daftar sekarang</a></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('bookingFlow', () => ({
            isModalOpen: false,
            targetBookingUrl: '',
            isLoading: false,
            errorMessage: '',
            errors: {},
            form: {
                email: '',
                password: '',
                _token: '{{ csrf_token() }}'
            },
            openModal(url) {
                this.targetBookingUrl = url;
                this.isModalOpen = true;
            },
            closeModal() {
                this.isModalOpen = false;
                this.errorMessage = '';
                this.errors = {};
                this.form.password = ''; // Kosongkan password demi keamanan
            },
            async submitLogin() {
                this.isLoading = true;
                this.errorMessage = '';
                this.errors = {};
                
                try {
                    // Pastikan route('login') aktif sesuai pengaturan di Laravel
                    const response = await fetch('{{ route('login') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': this.form._token
                        },
                        body: JSON.stringify(this.form)
                    });

                    if (response.ok || response.status === 204) {
                        // Login BERHASIL! Redirect ke halaman pilih kursi
                        window.location.href = this.targetBookingUrl;
                    } else if (response.status === 422) {
                        // Login GAGAL (Kredensial salah / Validasi error)
                        const data = await response.json();
                        this.errors = data.errors || {};
                        if(data.message) {
                            this.errorMessage = data.message;
                        }
                    } else {
                        // Error server 500 dll
                        this.errorMessage = 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    }
                } catch (error) {
                    console.error(error);
                    this.errorMessage = 'Gagal terhubung ke server. Periksa koneksi internet Anda.';
                } finally {
                    this.isLoading = false;
                }
            }
        }));
    });
</script>
@endsection