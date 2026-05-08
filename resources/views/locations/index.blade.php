<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Lokasi Bioskop</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .location-card {
            transition: all 0.3s ease;
        }
        .location-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .search-input {
            transition: all 0.3s ease;
        }
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        .tab-button {
            transition: all 0.3s ease;
        }
        .tab-button.active {
            border-bottom: 3px solid #ef4444;
            color: #ef4444;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Pilih Lokasi Bioskop</h1>
            </div>
            <p class="text-gray-600">Temukan bioskop terdekat dengan lokasi Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Search Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex gap-4 mb-6">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input 
                            type="text" 
                            id="searchInput"
                            class="search-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-0"
                            placeholder="Cari lokasi, kota, atau alamat..."
                            autocomplete="off"
                        >
                    </div>
                    <div id="searchResults" class="absolute top-20 left-4 right-4 bg-white border border-gray-300 rounded-lg shadow-lg max-h-96 overflow-y-auto hidden z-10"></div>
                </div>
                <button onclick="resetSearch()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </button>
            </div>

            <!-- Filter Tabs -->
            <div class="flex gap-6 border-b border-gray-200 pb-4">
                <button class="tab-button active px-4 py-2 font-medium" data-filter="all">
                    <i class="fas fa-th-large mr-2"></i>Semua Lokasi
                </button>
                <button class="tab-button px-4 py-2 font-medium" data-filter="popular">
                    <i class="fas fa-star mr-2"></i>Populer
                </button>
                <button class="tab-button px-4 py-2 font-medium" data-filter="nearby">
                    <i class="fas fa-map-marker-alt mr-2"></i>Terdekat
                </button>
            </div>
        </div>

        <!-- Locations Grid -->
        <div id="locationsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($locations as $location)
                <div class="location-card bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg" onclick="selectLocation({{ $location->id }}, '{{ $location->name }}')">
                    <!-- Location Header -->
                    <div class="h-40 bg-gradient-to-br from-red-500 to-red-700 relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20">
                            <i class="fas fa-building text-white text-8xl absolute bottom-0 right-0"></i>
                        </div>
                        <div class="absolute top-4 right-4 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold text-red-600">
                            {{ $location->studios->count() }} Studio
                        </div>
                    </div>

                    <!-- Location Info -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $location->name }}</h3>
                        
                        <div class="space-y-3">
                            <!-- City -->
                            <div class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt text-red-500 mt-1 flex-shrink-0"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Kota</p>
                                    <p class="text-gray-900 font-medium">{{ $location->city }}</p>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-start gap-3">
                                <i class="fas fa-home text-red-500 mt-1 flex-shrink-0"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Alamat</p>
                                    <p class="text-gray-700 text-sm line-clamp-2">{{ $location->address }}</p>
                                </div>
                            </div>

                            <!-- Studios -->
                            @if ($location->studios->count() > 0)
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-film text-red-500 mt-1 flex-shrink-0"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Studio Tersedia</p>
                                        <div class="flex flex-wrap gap-2 mt-1">
                                            @foreach ($location->studios->take(2) as $studio)
                                                <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                                    {{ $studio->studio_name }}
                                                </span>
                                            @endforeach
                                            @if ($location->studios->count() > 2)
                                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                                    +{{ $location->studios->count() - 2 }} lainnya
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <button class="w-full mt-6 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition" onclick="selectLocation({{ $location->id }}, '{{ $location->name }}', event)">
                            <i class="fas fa-check mr-2"></i>Pilih Lokasi Ini
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-600 text-lg">Tidak ada lokasi bioskop yang tersedia</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Loading State -->
    <div id="loadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8">
            <div class="flex flex-col items-center gap-4">
                <div class="w-12 h-12 border-4 border-red-200 border-t-red-500 rounded-full animate-spin"></div>
                <p class="text-gray-600">Memproses pilihan Anda...</p>
            </div>
        </div>
    </div>

    <script>
        // Simulasi data untuk pencarian
        const allLocations = @json($locations);

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            if (query.length === 0) {
                document.getElementById('searchResults').classList.add('hidden');
                return;
            }

            const filtered = allLocations.filter(loc => 
                loc.name.toLowerCase().includes(query) ||
                loc.city.toLowerCase().includes(query) ||
                loc.address.toLowerCase().includes(query)
            );

            if (filtered.length === 0) {
                document.getElementById('searchResults').innerHTML = '<div class="p-4 text-center text-gray-500">Tidak ada hasil</div>';
            } else {
                document.getElementById('searchResults').innerHTML = filtered.map(loc => `
                    <div class="p-3 border-b last:border-b-0 hover:bg-gray-100 cursor-pointer" onclick="selectLocation(${loc.id}, '${loc.name}')">
                        <p class="font-medium text-gray-900">${loc.name}</p>
                        <p class="text-sm text-gray-500">${loc.city}</p>
                    </div>
                `).join('');
            }
            document.getElementById('searchResults').classList.remove('hidden');
        });

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id !== 'searchInput') {
                document.getElementById('searchResults').classList.add('hidden');
            }
        });

        // Reset search
        function resetSearch() {
            document.getElementById('searchInput').value = '';
            document.getElementById('searchResults').classList.add('hidden');
            location.reload();
        }

        // Select location
        function selectLocation(locationId, locationName, event) {
            if (event) event.stopPropagation();
            
            // Show loading spinner
            document.getElementById('loadingSpinner').classList.remove('hidden');

            // Simulate API call with delay
            setTimeout(() => {
                // Store selected location in session/localStorage
                localStorage.setItem('selectedLocation', JSON.stringify({
                    id: locationId,
                    name: locationName,
                    selectedAt: new Date().toISOString()
                }));

                // Redirect ke halaman pemilihan jadwal/film
                window.location.href = `/location/${locationId}/schedules`;
            }, 800);
        }

        // Tab filtering
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                // Implement filter logic here
                console.log('Filter:', filter);
            });
        });

        // Initialize location count
        function updateLocationCount() {
            const count = document.querySelectorAll('.location-card').length;
            console.log(`Total lokasi: ${count}`);
        }

        document.addEventListener('DOMContentLoaded', updateLocationCount);
    </script>
</body>
</html>
