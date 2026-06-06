@extends('layouts.starter')

@section('title', 'Daftar - TiketBioskop')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-16" x-data="{ showPassword: false, showConfirm: false }">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[#4B3935] mb-4 shadow-lg">
                <svg class="w-8 h-8 text-[#CBDFEA]" fill="currentColor" viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h1 class="font-baloo text-3xl font-extrabold text-[#4B3935]">Buat Akun Baru</h1>
            <p class="text-sm text-[#708090] mt-1">Daftar untuk memesan tiket bioskop favoritmu</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-[#C8C2BC]/30 p-8">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-[#4B3935] mb-1.5">Nama Lengkap</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 rounded-xl border border-[#C8C2BC]/50 bg-[#FAF3E0]/50 text-[#4B3935] text-sm placeholder-[#708090]/60 focus:outline-none focus:ring-2 focus:ring-[#4B3935]/30 focus:border-[#4B3935] transition-all"
                    >
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-bold text-[#4B3935] mb-1.5">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        placeholder="nama@email.com"
                        class="w-full px-4 py-3 rounded-xl border border-[#C8C2BC]/50 bg-[#FAF3E0]/50 text-[#4B3935] text-sm placeholder-[#708090]/60 focus:outline-none focus:ring-2 focus:ring-[#4B3935]/30 focus:border-[#4B3935] transition-all"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-bold text-[#4B3935] mb-1.5">Password</label>
                    <div class="relative">
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-3 rounded-xl border border-[#C8C2BC]/50 bg-[#FAF3E0]/50 text-[#4B3935] text-sm placeholder-[#708090]/60 focus:outline-none focus:ring-2 focus:ring-[#4B3935]/30 focus:border-[#4B3935] transition-all pr-12"
                        >
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#708090] hover:text-[#4B3935] transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" style="display:none" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-[#4B3935] mb-1.5">Konfirmasi Password</label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            :type="showConfirm ? 'text' : 'password'"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi password"
                            class="w-full px-4 py-3 rounded-xl border border-[#C8C2BC]/50 bg-[#FAF3E0]/50 text-[#4B3935] text-sm placeholder-[#708090]/60 focus:outline-none focus:ring-2 focus:ring-[#4B3935]/30 focus:border-[#4B3935] transition-all pr-12"
                        >
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#708090] hover:text-[#4B3935] transition-colors">
                            <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showConfirm" style="display:none" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] font-bold py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm tracking-wide"
                >
                    Daftar
                </button>
            </form>
        </div>

        {{-- Login link --}}
        <p class="text-center text-sm text-[#708090] mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-[#4B3935] hover:underline">Masuk di sini</a>
        </p>

    </div>
</div>
@endsection
