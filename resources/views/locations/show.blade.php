<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $location->name }} - Tiket Bioskop</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('locations.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $location->name }}</h1>
            </div>
            <p class="text-gray-600">Lokasi di {{ $location->city }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Location Details -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Lokasi</h2>
                    
                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start gap-4">
                            <div class="text-2xl text-red-500">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Alamat</h3>
                                <p class="text-gray-700">{{ $location->address }}</p>
                                <p class="text-gray-600 mt-2">Kota: <span class="font-medium">{{ $location->city }}</span></p>
                            </div>
                        </div>

                        <!-- Contact -->
                        <div class="flex items-start gap-4">
                            <div class="text-2xl text-red-500">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Kontak</h3>
                                <p class="text-gray-700">+62-21-1234567</p>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="flex items-start gap-4">
                            <div class="text-2xl text-red-500">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Jam Operasional</h3>
                                <p class="text-gray-700">Senin - Jumat: 10:00 - 23:00</p>
                                <p class="text-gray-700">Sabtu - Minggu: 09:00 - 24:00</p>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="flex items-start gap-4">
                            <div class="text-2xl text-red-500">
                                <i class="fas fa-star"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Fasilitas</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <i class="fas fa-wifi text-red-500"></i> WiFi Gratis
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <i class="fas fa-parking text-red-500"></i> Parkir
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <i class="fas fa-utensils text-red-500"></i> Food Court
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <i class="fas fa-accessible-icon text-red-500"></i> Akses Disabilitas
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Studios -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Studio</h2>
                    
                    @if ($location->studios->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($location->studios as $studio)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-red-500 transition">
                                    <h3 class="font-bold text-gray-900 mb-2">{{ $studio->studio_name }}</h3>
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        <span><i class="fas fa-chair mr-1"></i> Kapasitas: {{ $studio->capacity }} kursi</span>
                                        <span><i class="fas fa-tag mr-1"></i> {{ $studio->studio_type }}</span>
                                    </div>
                                    <button class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition text-sm">
                                        Lihat Jadwal
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-600">
                            <i class="fas fa-inbox text-gray-400 text-4xl mb-3"></i>
                            <p>Belum ada studio di lokasi ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Action -->
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <a href="{{ route('location.schedules', ['id' => $location->id]) }}" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg transition block text-center mb-3">
                        <i class="fas fa-ticket-alt mr-2"></i>Pesan Tiket Sekarang
                    </a>
                    
                    <button onclick="goBack()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </button>

                    <!-- Stats -->
                    <div class="mt-6 space-y-4 border-t border-gray-200 pt-6">
                        <div>
                            <p class="text-gray-600 text-sm">Total Studio</p>
                            <p class="text-2xl font-bold text-red-500">{{ $location->studios->count() }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Total Kursi</p>
                            <p class="text-2xl font-bold text-red-500">{{ $location->studios->sum('capacity') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            history.back();
        }
    </script>
</body>
</html>
