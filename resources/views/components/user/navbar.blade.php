<nav class="font-baloo relative w-full bg-[#4B3935] shadow-sm z-50" x-data="{ isMobileOpen: false, isProfileOpen: false }">
    <div class="flex items-center justify-between w-full max-w-7xl mx-auto px-4 md:px-10 py-4 md:py-5">
        <div class="flex items-center flex-shrink-0">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <svg class="w-8 h-8 text-[#CBDFEA]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.82 2H4.18C2.97 2 2 2.97 2 4.18v15.64C2 21.03 2.97 22 4.18 22h15.64c1.21 0 2.18-.97 2.18-2.18V4.18C22 2.97 21.03 2 19.82 2zM4 5.5h3v2H4v-2zm0 5h3v2H4v-2zm0 5h3v2H4v-2zm16 4.5H4v-2h16v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2z"/></svg>
                <div class="flex flex-col">
                    <span class="text-lg font-black text-[#FAF3E0] tracking-wider leading-none">TIKET<span class="text-[#CBDFEA]">BIOSKOP</span></span>
                    <span class="text-[9px] font-bold text-[#FAF3E0]/70 tracking-widest mt-1.5 uppercase">Sistem Pemesanan Tiket Film</span>
                </div>
            </a>
        </div>

        <button 
            class="md:hidden p-2 text-[#FAF3E0] hover:text-white focus:outline-none"
            @click="isMobileOpen = !isMobileOpen"
        >
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="isMobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                <path x-show="!isMobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>      
        </button>

        <div class="hidden md:flex items-center justify-between flex-1 ml-8">
            
            <div class="flex-1 max-w-md relative">
                <form action="{{ route('movies.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari film..." class="w-full bg-[#FAF3E0]/10 border border-[#FAF3E0]/20 px-4 py-2 rounded-full text-sm text-[#FAF3E0] placeholder-[#FAF3E0]/50 focus:outline-none focus:ring-2 focus:ring-[#fadd39] focus:bg-white/20 transition-all">
                    <button type="submit" class="absolute right-3 top-2.5 text-[#FAF3E0]/50 hover:text-[#fadd39] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
            
            <div class="flex items-center gap-8 ml-8">
                <div class="flex gap-6 text-sm font-bold text-[#FAF3E0]/80">
                    <a href="{{ route('landing') }}" class="hover:text-[#fadd39] transition-colors">Beranda</a>
                    <a href="{{ route('movies.index') }}" class="hover:text-[#fadd39] transition-colors">Film</a>
                    
                    <a href="{{ route('cinemas.index') }}" class="hover:text-[#fadd39] transition-colors">Bioskop</a>
                    
                    @if(auth()->check())
                        <a href="{{ route('transactions.history') }}" class="hover:text-[#fadd39] transition-colors">Riwayat</a>
                    @endif
                    
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('admin.analytics.index') }}" class="text-red-400 font-bold hover:text-red-300 transition-colors">Panel Admin</a>
                    @endif
                </div>
                
                @auth
                    <div class="flex items-center gap-3 relative">
                        <span class="text-sm font-bold text-[#FAF3E0]">
                            {{ auth()->user()->name }}
                        </span>
                        
                        <button @click="isProfileOpen = !isProfileOpen" @click.away="isProfileOpen = false" class="focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FAF3E0&color=4B3935" alt="User" class="w-10 h-10 rounded-full border-2 border-transparent hover:border-[#FAF3E0]/30 transition-all">
                        </button>

                        <div x-show="isProfileOpen" 
                             x-transition.opacity 
                             style="display: none;" 
                             class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            
                            <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                <span class="block text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</span>
                                <span class="block text-xs font-medium text-gray-500 truncate">{{ auth()->user()->email }}</span>
                            </div>

                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.analytics.index') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50 font-bold">Panel Admin</a>
                            @endif
                            <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-semibold">Profil Saya</a>

                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" class="bg-[#FAF3E0] hover:bg-white text-[#4B3935] text-sm font-bold px-6 py-2 rounded-3xl transition-colors shadow-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-[#4B3935] hover:bg-[#5c4944] text-[#FAF3E0] text-sm font-bold px-6 py-2 rounded-3xl border border-[#FAF3E0]/30 transition-colors shadow-sm">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div x-show="isMobileOpen" 
         x-transition.duration.200ms
         style="display: none;" 
         class="md:hidden absolute top-full left-0 w-full bg-[#4B3935] shadow-xl border-t border-[#4B3935]/20 flex flex-col p-6 gap-6 z-50">
        
        <div class="w-full">
            <form action="{{ route('movies.index') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Cari film..." class="w-full bg-[#FAF3E0]/10 border border-[#FAF3E0]/20 px-4 py-3 rounded-xl text-sm text-[#FAF3E0] placeholder-[#FAF3E0]/50 focus:outline-none">
            </form>
        </div>

        <div class="flex flex-col gap-4 border-b border-[#FAF3E0]/10 pb-6 text-lg font-bold text-[#FAF3E0]/80">
            <a href="{{ route('landing') }}" class="hover:text-white">Beranda</a>
            <a href="{{ route('movies.index') }}" class="hover:text-white">Film</a>
            
            <a href="{{ route('cinemas.index') }}" class="hover:text-white">Bioskop</a>
            
            @if(auth()->check())
                <a href="{{ route('transactions.history') }}" class="hover:text-white">Riwayat</a>
            @endif
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.analytics.index') }}" class="text-red-400 font-bold">Panel Admin</a>
            @endif
        </div>

        <div>
            @auth
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FAF3E0&color=4B3935" class="w-12 h-12 rounded-full">
                        <div>
                            <span class="block text-base font-bold text-[#FAF3E0]">{{ auth()->user()->name }}</span>
                            <span class="block text-sm font-medium text-[#FAF3E0]/70">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 mt-2">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.analytics.index') }}" class="text-left font-bold text-red-400 py-2">Panel Admin</a>
                        @endif
                        <a href="{{ url('/profile') }}" class="text-left font-bold text-[#FAF3E0] py-2">Profil Saya</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-left font-bold text-red-400 py-2 w-full">Sign out</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    <a href="{{ route('login') }}" class="bg-[#FAF3E0] text-[#4B3935] text-center font-bold px-6 py-3 rounded-xl shadow-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-[#4B3935] text-[#FAF3E0] border border-[#FAF3E0]/30 text-center font-bold px-6 py-3 rounded-xl shadow-sm">
                        Sign Up
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>