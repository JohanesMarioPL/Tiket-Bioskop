@extends('layouts.starter')

@section('title', 'Login - TiketBioskop')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-16" x-data="{ showPassword: false }">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[#4B3935] mb-4 shadow-lg">
                <svg class="w-8 h-8 text-[#CBDFEA]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.82 2H4.18C2.97 2 2 2.97 2 4.18v15.64C2 21.03 2.97 22 4.18 22h15.64c1.21 0 2.18-.97 2.18-2.18V4.18C22 2.97 21.03 2 19.82 2zM4 5.5h3v2H4v-2zm0 5h3v2H4v-2zm0 5h3v2H4v-2zm16 4.5H4v-2h16v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2z"/></svg>
            </div>
            <h1 class="font-baloo text-3xl font-extrabold text-[#4B3935]">Selamat Datang!</h1>
            <p class="text-sm text-[#708090] mt-1">Masuk ke akun TiketBioskop kamu</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-[#C8C2BC]/30 p-8">

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 p-3 rounded-xl bg-green-50 border border-green-200 text-sm font-semibold text-green-700">
                    {{ session('status') }}
                </div>
            @endif

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

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-bold text-[#4B3935] mb-1.5">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
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
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 rounded-xl border border-[#C8C2BC]/50 bg-[#FAF3E0]/50 text-[#4B3935] text-sm placeholder-[#708090]/60 focus:outline-none focus:ring-2 focus:ring-[#4B3935]/30 focus:border-[#4B3935] transition-all pr-12"
                        >
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#708090] hover:text-[#4B3935] transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" style="display:none" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between">
                    <label for="remember" class="flex items-center gap-2 cursor-pointer">
                        <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded border-[#C8C2BC] text-[#4B3935] focus:ring-[#4B3935]/30">
                        <span class="text-sm text-[#708090]">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#4B3935] hover:text-[#708090] transition-colors">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] font-bold py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm tracking-wide"
                >
                    Masuk
                </button>
            </form>
        </div>

        {{-- Register link --}}
        <p class="text-center text-sm text-[#708090] mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-bold text-[#4B3935] hover:underline">Daftar sekarang</a>
        </p>

    </div>
</div>
@endsection
