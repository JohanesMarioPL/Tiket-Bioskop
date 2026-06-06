<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sang Pengadil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF5E6] min-h-screen text-[#4A3B32]">

    <div class="max-w-4xl mx-auto px-6 py-12 space-y-12">
        
        <div>
            <h1 class="text-[28px] font-extrabold mb-2 text-[#4A3B32]">Ratings & Reviews</h1>
            <p class="text-sm font-medium opacity-70 text-[#4A3B32]">Bagikan pengalaman menontonmu untuk film ini.</p>
        </div>

        <div class="bg-[#CDE0EB] rounded-[20px] p-8 shadow-sm">
            
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-[#8BA7B8]/30">
                <div class="w-16 h-20 bg-[#C4CCD3] rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                    @if($movie && $movie->poster_url)
                        <img src="{{ asset('storage/' . $movie->poster_url) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-60" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h2v2H4zm0 5h2v2H4zm0 5h2v2H4zm16-10h-2v2h2zm0 5h-2v2h2zm0 5h-2v2h2zM8 4h8v16H8z"/></svg>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-[#4A3B32] opacity-70 mb-1">Menulis ulasan untuk</p>
                    <h2 class="text-xl font-extrabold text-[#4A3B32]">{{ $movie->title ?? 'Film Tidak Ditemukan' }}</h2>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-[#FAF5E6] border-l-4 border-green-500 text-[#4A3B32] rounded-r-xl text-sm font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $movie->id ?? '' }}">

                <div class="mb-6">
                    <label class="block text-[11px] font-extrabold uppercase tracking-widest mb-2 text-[#4A3B32]">Berikan Rating</label>
                    
                    <input type="hidden" name="rating" id="ratingInput" required>
                    
                    <div class="flex gap-2" id="starContainer">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn text-[#C4CCD3] hover:text-[#F59E0B] hover:scale-110 transition-all duration-200 focus:outline-none" data-value="{{ $i }}">
                                <svg class="w-10 h-10 fill-current drop-shadow-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <p id="ratingText" class="text-[11px] font-bold text-[#4A3B32] mt-2 opacity-0 transition-opacity"></p>
                </div>

                <div class="mb-6">
                    <label class="block text-[11px] font-extrabold uppercase tracking-widest mb-2 text-[#4A3B32]">Komentar (Opsional)</label>
                    <textarea name="comment" rows="4" placeholder="Bagaimana menurutmu filmnya?" class="w-full bg-[#FAF5E6] border-none rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-[#4A3B32] outline-none text-[#4A3B32] font-medium placeholder:font-normal placeholder:opacity-50 resize-none"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#4A3B32] text-white px-8 py-3.5 rounded-xl text-sm font-bold hover:bg-[#362a23] transition-colors shadow-sm">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>

        <div>
            <h3 class="text-lg font-extrabold text-[#4A3B32] mb-6 border-b-2 border-[#4A3B32] inline-block pb-1">Ulasan Penonton Lain</h3>
            
            <div class="space-y-4">
                @forelse($reviews as $review)
                    <div class="bg-white p-6 rounded-[20px] shadow-sm border border-slate-100 flex gap-4 transition-transform hover:-translate-y-1">
                        <div class="w-12 h-12 bg-[#CDE0EB] rounded-full flex items-center justify-center font-extrabold text-[#4A3B32] flex-shrink-0">
                            U{{ $review->user_id }}
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-[15px] text-[#4A3B32]">User {{ $review->user_id }}</h4>
                                    <p class="text-[11px] text-slate-400 font-medium">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-yellow-500 text-xs tracking-widest">
                                    <div class="flex gap-0.5 text-[#F59E0B]">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-3.5 h-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @else
                                                <svg class="w-3.5 h-3.5 text-[#E5E7EB] fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-[13px] text-slate-600 font-medium leading-relaxed mt-2">
                                "{{ $review->comment ?? 'Memberikan rating tanpa komentar tertulis.' }}"
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white/50 rounded-[20px] border-2 border-dashed border-[#CDE0EB]">
                        <p class="text-[#4A3B32] font-bold opacity-50">Belum ada ulasan untuk film ini.</p>
                        <p class="text-sm text-[#4A3B32] opacity-40 mt-1">Jadilah yang pertama memberikan penilaian!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</body>

<script>
    const stars = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.getElementById('ratingText');

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            ratingInput.value = star.getAttribute('data-value');
            stars.forEach((s, i) => {
                if (i <= index) {
                    s.classList.remove('text-[#C4CCD3]');
                    s.classList.add('text-[#F59E0B]'); 
                } else {
                    s.classList.add('text-[#C4CCD3]'); 
                    s.classList.remove('text-[#F59E0B]');
                }
            });
        });
    });
</script>
</html>