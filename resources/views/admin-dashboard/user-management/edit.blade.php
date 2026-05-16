@extends('layouts.admin')

@section('title', 'Edit Pengguna: ' . $user->name)
@section('header', 'Edit Pengguna')

@section('content')
<div class="w-full">
    
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-[#cbdfea] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="p-6 lg:p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit Informasi Pengguna</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui detail informasi untuk akun <span class="font-bold text-slate-700">"{{ $user->name }}"</span></p>
            </div>
            <div class="text-right">
                <span class="text-xs font-medium text-slate-400">ID Pengguna: #{{ $user->id }}</span>
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

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 lg:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $user->name) }}" 
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email', $user->email) }}" 
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Kosongkan jika tidak ingin mengubah kata sandi"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm"
                    >
                </div>

                <div>
                    <label for="role" class="block text-sm font-bold text-slate-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select 
                        name="role" 
                        id="role" 
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#708090] focus:border-[#708090] transition-shadow shadow-sm bg-white"
                    >
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Customer / User</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors text-sm">
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
@endsection