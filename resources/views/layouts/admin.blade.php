<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bioskop - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-slate-900">
    
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        @include('components.admin.sidebar')

        <div class="flex flex-col flex-1 w-full md:ml-64 transition-all">
            
            @include('components.admin.navbar')

            <main class="flex-1 overflow-y-auto p-6 lg:p-10 w-full">
                @yield('content')
            </main>
            
        </div>
    </div>

</body>
</html>