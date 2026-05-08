<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jadwal - Tiket Bioskop</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .breadcrumb-item.active {
            color: #ef4444;
            font-weight: 600;
        }
        .step-indicator {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .step {
            flex: 1;
            text-align: center;
        }
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .step.active .step-number {
            background-color: #ef4444;
            color: white;
        }
        .step.completed .step-number {
            background-color: #10b981;
            color: white;
        }
        .step.pending .step-number {
            background-color: #e5e7eb;
            color: #9ca3af;
        }
        .step-line {
            position: absolute;
            top: 3rem;
            left: 50%;
            width: 50%;
            height: 2px;
            background-color: #e5e7eb;
            transform: translateX(50%);
        }
        .step.completed .step-line {
            background-color: #10b981;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-4 text-sm">
                <a href="{{ route('locations.index') }}" class="text-gray-600 hover:text-gray-900 breadcrumb-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Pilih Lokasi</span>
                </a>
                <i class="fas fa-chevron-right text-gray-400"></i>
                <span class="breadcrumb-item active">
                    <i class="fas fa-film"></i>
                    <span>Pilih Film & Jadwal</span>
                </span>
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-number">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Lokasi</p>
                </div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <p class="text-sm font-medium text-gray-700">Film & Jadwal</p>
                </div>
                <div class="step pending">
                    <div class="step-number">3</div>
                    <p class="text-sm font-medium text-gray-700">Kursi</p>
                </div>
                <div class="step pending">
                    <div class="step-number">4</div>
                    <p class="text-sm font-medium text-gray-700">Pembayaran</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Location Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2" id="selectedLocationName">Memuat lokasi...</h2>
                    <p class="text-gray-600" id="selectedLocationInfo"></p>
                </div>
                <a href="{{ route('locations.index') }}" class="px-4 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition">
                    <i class="fas fa-exchange-alt mr-2"></i>Ganti Lokasi
                </a>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Pilih Tanggal</h3>
            <div class="flex gap-3 overflow-x-auto pb-2">
                <button class="date-btn px-4 py-2 border border-gray-300 rounded-lg whitespace-nowrap hover:border-red-500 transition" data-date="today">
                    <div class="text-sm text-gray-600">Hari Ini</div>
                    <div class="font-semibold" id="today-date"></div>
                </button>
                <button class="date-btn px-4 py-2 border border-gray-300 rounded-lg whitespace-nowrap hover:border-red-500 transition" data-date="tomorrow">
                    <div class="text-sm text-gray-600">Besok</div>
                    <div class="font-semibold" id="tomorrow-date"></div>
                </button>
                <button class="date-btn px-4 py-2 border border-gray-300 rounded-lg whitespace-nowrap hover:border-red-500 transition" data-date="next-3">
                    <div class="text-sm text-gray-600">3 Hari</div>
                    <div class="font-semibold" id="next3-date"></div>
                </button>
                <button class="date-btn px-4 py-2 border border-gray-300 rounded-lg whitespace-nowrap hover:border-red-500 transition" data-date="week">
                    <div class="text-sm text-gray-600">1 Minggu</div>
                    <div class="font-semibold" id="week-date"></div>
                </button>
            </div>
        </div>

        <!-- Movies Schedule Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Filter</h3>
                    
                    <!-- Genre Filter -->
                    <div class="mb-6">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Genre</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="filter-genre" value="action" checked>
                                <span class="text-gray-700">Action</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="filter-genre" value="drama" checked>
                                <span class="text-gray-700">Drama</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="filter-genre" value="comedy" checked>
                                <span class="text-gray-700">Comedy</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="filter-genre" value="horror" checked>
                                <span class="text-gray-700">Horror</span>
                            </label>
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-6">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Rating</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="rating" value="all" checked>
                                <span class="text-gray-700">Semua Rating</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="rating" value="4">
                                <span class="text-gray-700">⭐ 4+ Bintang</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="rating" value="3">
                                <span class="text-gray-700">⭐ 3+ Bintang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Time Filter -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Waktu Tayangan</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="filter-time" value="morning" checked>
                                <span class="text-gray-700">Pagi (06:00-12:00)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="filter-time" value="afternoon" checked>
                                <span class="text-gray-700">Siang (12:00-17:00)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="filter-time" value="evening" checked>
                                <span class="text-gray-700">Malam (17:00-23:59)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movies List -->
            <div class="lg:col-span-3">
                <div id="moviesContainer" class="space-y-6">
                    <!-- Movie cards will be loaded here -->
                    <div class="text-center py-12">
                        <i class="fas fa-film text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-600">Memuat film dan jadwal...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize dates
        function initializeDates() {
            const today = new Date();
            const formatter = new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short' });
            
            document.getElementById('today-date').textContent = formatter.format(today);
            document.getElementById('tomorrow-date').textContent = formatter.format(new Date(today.getTime() + 24 * 60 * 60 * 1000));
            document.getElementById('next3-date').textContent = formatter.format(new Date(today.getTime() + 3 * 24 * 60 * 60 * 1000));
            document.getElementById('week-date').textContent = formatter.format(new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000));
        }

        // Load selected location
        function loadSelectedLocation() {
            const selectedLocation = localStorage.getItem('selectedLocation');
            if (selectedLocation) {
                const location = JSON.parse(selectedLocation);
                document.getElementById('selectedLocationName').textContent = location.name;
                document.getElementById('selectedLocationInfo').textContent = `Lokasi: ${location.name} • ID: ${location.id}`;
            }
        }

        // Sample movie data (dalam praktik akan di-load dari API)
        function loadMovies() {
            const movies = [
                {
                    id: 1,
                    title: 'Avengers: Endgame',
                    genre: 'action',
                    rating: 4.8,
                    duration: 181,
                    image: 'https://via.placeholder.com/300x450?text=Avengers',
                    schedules: [
                        { time: '10:00', studio: 'Studio 1' },
                        { time: '13:30', studio: 'Studio 2' },
                        { time: '16:45', studio: 'Studio 1' },
                        { time: '19:30', studio: 'Studio 3' }
                    ]
                },
                {
                    id: 2,
                    title: 'The Shawshank Redemption',
                    genre: 'drama',
                    rating: 4.9,
                    duration: 142,
                    image: 'https://via.placeholder.com/300x450?text=Shawshank',
                    schedules: [
                        { time: '11:00', studio: 'Studio 2' },
                        { time: '14:00', studio: 'Studio 1' },
                        { time: '20:00', studio: 'Studio 2' }
                    ]
                },
                {
                    id: 3,
                    title: 'Pulp Fiction',
                    genre: 'drama',
                    rating: 4.7,
                    duration: 154,
                    image: 'https://via.placeholder.com/300x450?text=PulpFiction',
                    schedules: [
                        { time: '09:00', studio: 'Studio 1' },
                        { time: '15:30', studio: 'Studio 3' },
                        { time: '21:00', studio: 'Studio 2' }
                    ]
                }
            ];

            renderMovies(movies);
        }

        function renderMovies(movies) {
            const container = document.getElementById('moviesContainer');
            container.innerHTML = movies.map(movie => `
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="flex gap-4 p-6">
                        <!-- Movie Poster -->
                        <div class="flex-shrink-0 w-24 h-36 rounded-lg overflow-hidden">
                            <img src="${movie.image}" alt="${movie.title}" class="w-full h-full object-cover">
                        </div>

                        <!-- Movie Info -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-lg font-bold text-gray-900">${movie.title}</h4>
                                <span class="text-yellow-500">⭐ ${movie.rating}</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">
                                <i class="fas fa-tag"></i> ${movie.genre.toUpperCase()} • 
                                <i class="fas fa-clock"></i> ${movie.duration} menit
                            </p>

                            <!-- Schedules -->
                            <div class="space-y-3">
                                <p class="text-sm font-semibold text-gray-700">Pilih Jadwal:</p>
                                <div class="flex flex-wrap gap-2">
                                    ${movie.schedules.map((schedule, index) => `
                                        <button onclick="selectSchedule(${movie.id}, '${movie.title}', '${schedule.time}', '${schedule.studio}', event)" class="px-3 py-2 bg-gray-100 hover:bg-red-500 hover:text-white text-gray-700 rounded-lg font-medium text-sm transition cursor-pointer">
                                            ${schedule.time} • ${schedule.studio}
                                        </button>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function selectSchedule(movieId, movieTitle, time, studio, event) {
            event.preventDefault();
            
            // Save selection to localStorage
            localStorage.setItem('selectedSchedule', JSON.stringify({
                movieId,
                movieTitle,
                time,
                studio,
                selectedAt: new Date().toISOString()
            }));

            // Redirect to seat selection
            alert(`✓ ${movieTitle} - ${time} (${studio}) dipilih!\n\nRedirek ke pemilihan kursi...`);
            // window.location.href = '/seats';
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeDates();
            loadSelectedLocation();
            loadMovies();

            // Date button click handlers
            document.querySelectorAll('.date-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('border-red-500', 'bg-red-50'));
                    this.classList.add('border-red-500', 'bg-red-50');
                });
            });
        });
    </script>
</body>
</html>
