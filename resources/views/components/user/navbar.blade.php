<nav class="font-baloo relative w-full bg-transparent z-50" x-data="{ isMobileOpen: false, isProfileOpen: false }">
    <div class="flex items-center justify-between w-full max-w-7xl mx-auto px-4 md:px-10 py-4 md:py-6">
        <div class="flex items-center flex-shrink-0">
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <svg class="w-8 h-8 text-[#97b3c2]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.82 2H4.18C2.97 2 2 2.97 2 4.18v15.64C2 21.03 2.97 22 4.18 22h15.64c1.21 0 2.18-.97 2.18-2.18V4.18C22 2.97 21.03 2 19.82 2zM4 5.5h3v2H4v-2zm0 5h3v2H4v-2zm0 5h3v2H4v-2zm16 4.5H4v-2h16v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2z"/></svg><span class="text-xl font-black text-[#222432] tracking-wider">TIKET<span class="text-[#97b3c2]">BIOSKOP</span></span> 
            </a>
        </div>

        <button 
            class="md:hidden p-2 text-gray-700 hover:text-gray-900 focus:outline-none"
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
                    <input type="text" name="search" placeholder="Cari film..." class="w-full bg-white border border-gray-200 px-4 py-2 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#fadd39]">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-[#fadd39] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
            
            <div class="flex items-center gap-8 ml-8">
                <div class="flex gap-6 text-sm font-bold text-gray-700">
                    <a href="{{ route('landing') }}" class="hover:text-[#fadd39] transition-colors">Beranda</a>
                    <a href="{{ route('movies.index') }}" class="hover:text-[#fadd39] transition-colors">Film</a>
                    <a href="" class="hover:text-[#fadd39] transition-colors">Lokasi</a>
                </div>
                
                @auth
                    <div class="flex items-center gap-3 relative">
                        <span class="text-sm font-bold text-[#222432]">
                            {{ auth()->user()->name }}
                        </span>
                        
                        <button @click="isProfileOpen = !isProfileOpen" @click.away="isProfileOpen = false" class="focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=222432&color=fff" alt="User" class="w-10 h-10 rounded-full border-2 border-transparent hover:border-gray-300 transition-all">
                        </button>

                        <div x-show="isProfileOpen" 
                             x-transition.opacity 
                             style="display: none;" 
                             class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            
                            <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                <span class="block text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</span>
                                <span class="block text-xs font-medium text-gray-500 truncate">{{ auth()->user()->email }}</span>
                            </div>

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
                        <a href="{{ route('login') }}" class="bg-[#222432] hover:bg-gray-800 text-white text-sm font-bold px-6 py-2 rounded-3xl transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-[#222432] text-sm font-bold px-6 py-2 rounded-3xl border border-gray-200 transition-colors">
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
         class="md:hidden absolute top-full left-0 w-full bg-white shadow-xl border-t border-gray-100 flex flex-col p-6 gap-6 z-50">
        
        <div class="w-full">
            <form action="{{ route('movies.index') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Cari film..." class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none">
            </form>
        </div>

        <div class="flex flex-col gap-4 border-b border-gray-100 pb-6 text-lg font-bold text-gray-700">
            <a href="{{ route('landing') }}">Beranda</a>
            <a href="{{ route('movies.index') }}">Film</a>
            <a href="">Lokasi</a>
        </div>

        <div>
            @auth
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=222432&color=fff" class="w-12 h-12 rounded-full">
                        <div>
                            <span class="block text-base font-bold text-gray-900">{{ auth()->user()->name }}</span>
                            <span class="block text-sm font-medium text-gray-500">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 mt-2">
                        <a href="{{ url('/profile') }}" class="text-left font-bold text-gray-700 py-2">Profil Saya</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-left font-bold text-red-600 py-2 w-full">Sign out</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    <a href="{{ route('login') }}" class="bg-[#222432] text-white text-center font-bold px-6 py-3 rounded-xl">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gray-100 text-[#222432] text-center font-bold px-6 py-3 rounded-xl">
                        Sign Up
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>