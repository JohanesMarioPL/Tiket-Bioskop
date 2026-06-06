<aside class="w-60 h-screen bg-[#4B3935] border-r border-[#FAF3E0]/15 transition-transform -translate-x-full md:translate-x-0 flex flex-col fixed z-20 shadow-xl" aria-label="Sidenav">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div class="flex items-center justify-center pt-5 pb-4 mb-1 border-b border-[#FAF3E0]/15">
        <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3">
            <svg class="w-7 h-7 text-[#CBDFEA]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.82 2H4.18C2.97 2 2 2.97 2 4.18v15.64C2 21.03 2.97 22 4.18 22h15.64c1.21 0 2.18-.97 2.18-2.18V4.18C22 2.97 21.03 2 19.82 2zM4 5.5h3v2H4v-2zm0 5h3v2H4v-2zm0 5h3v2H4v-2zm16 4.5H4v-2h16v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2zm0-5h-3v-2h3v2z"/></svg>
            <span class="text-lg font-black text-[#FAF3E0] tracking-wider">ADMIN<span class="text-[#CBDFEA]">BIOSKOP</span></span>
        </a>
    </div>

    <div class="overflow-y-auto no-scrollbar px-3 py-3 h-full flex-1">
        <ul class="space-y-1 text-sm font-medium">
            <li>
                <a href="{{ route('admin.analytics.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.analytics.index') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.movies.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.movies.*') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                    <span>Manajemen Film</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.reviews.*') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <span>Ulasan Penonton</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.locations.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.locations.*') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Lokasi</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.studio.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.studio.*') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Manajemen Studio</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.showtimes.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.showtimes.*') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Jadwal Tayang</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    <span>Daftar Transaksi</span>
                </a>
            </li>
            
            <li class="pt-3 mt-3 space-y-1 border-t border-[#FAF3E0]/15">
                <p class="px-3 text-[10px] font-bold text-[#FAF3E0]/50 uppercase tracking-wider">Sistem</p>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-[#CBDFEA] text-[#4B3935] shadow-md font-bold' : 'text-[#FAF3E0]/80 hover:text-white hover:bg-[#5c4944]' }}">
                    <svg class="w-5 h-5 mr-2.5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Manajemen User</span>
                </a>
            </li>
        </ul>
    </div>
</aside>