<nav class="bg-white px-6 py-4 lg:px-10 lg:py-5 w-full z-10 flex items-center justify-between border-b border-gray-200 shadow-sm transition-all">
    
    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
        @yield('header', 'Dashboard')
    </h2>

    <div class="flex items-center space-x-6">
        @include('components.admin.profile-dropdown')
    </div>
</nav>