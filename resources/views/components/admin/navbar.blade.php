<nav class="bg-[#4B3935] px-5 py-3 lg:px-6 lg:py-3.5 w-full z-10 flex items-center justify-between border-b border-[#FAF3E0]/15 shadow-sm transition-all">
    
    <h2 class="text-lg lg:text-xl font-black text-[#FAF3E0] tracking-tight">
        @yield('header', 'Dashboard')
    </h2>

    <div class="flex items-center space-x-6">
        @include('components.admin.profile-dropdown')
    </div>
</nav>