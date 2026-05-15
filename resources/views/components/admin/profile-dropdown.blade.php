<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 focus:outline-none group">
        <div class="text-right hidden md:block">
            <p class="text-sm font-bold text-slate-800 group-hover:text-[#708090] transition-colors">
                Jane Doe
            </p>
            <p class="text-xs font-medium text-slate-500">
                Admin
            </p>
        </div>
        
        <div class="relative flex-shrink-0">
            <img 
                class="w-10 h-10 rounded-full object-cover border-2 border-[#cbdfea] p-[2px] transition-transform group-hover:scale-105" 
                src="https://ui-avatars.com/api/?name=Jane+Doe&background=344152&color=cbdfea" 
                alt="Admin avatar" 
            />
            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
        </div>

        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 flex-shrink-0" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50"
        style="display: none;"
    >
        <div class="px-4 py-2 border-b border-slate-50 mb-1">
            <p class="text-xs text-slate-400 uppercase font-semibold tracking-wider">Akun Saya</p>
        </div>

        <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-[#cbdfea]/30 hover:text-[#344152] transition-colors">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Profil Detail
        </a>

        <a href="{{ url('/') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-[#cbdfea]/30 hover:text-[#344152] transition-colors">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Lihat Sebagai Pembeli
        </a>

        <div class="border-t border-slate-50 mt-2 pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </div>
</div>