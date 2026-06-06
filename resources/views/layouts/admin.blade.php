<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bioskop - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF3E0] font-sans antialiased text-[#4B3935] text-sm">
    
    <div class="flex h-screen bg-[#FAF3E0] overflow-hidden">
        @include('components.admin.sidebar')

        <div class="flex flex-col flex-1 w-full md:ml-60 transition-all">
            
            @include('components.admin.navbar')

            <main class="flex-1 overflow-y-auto p-4 lg:p-6 w-full">
                @yield('content')
            </main>
            
        </div>
    </div>

</body>
</html>