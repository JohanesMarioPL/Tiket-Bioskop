<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showReviewModal: false, selectedMovieId: null, selectedMovieTitle: '', selectedMoviePoster: '', rating: 0, comment: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl text-sm font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($transactions->isEmpty())
                    <p class="text-gray-500 text-center">{{ __('Belum ada riwayat transaksi.') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Film</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaction->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                            {{ $transaction->transaction_code }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            @php
                                                $movies = $transaction->tickets->map(function($ticket) {
                                                    return $ticket->schedule->movie->title;
                                                })->unique();
                                            @endphp
                                            {{ $movies->implode(', ') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $transaction->status === 'success' ? 'bg-green-100 text-green-800' : ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if($transaction->status === 'paid' && ($movieId = ($transaction->tickets->first()->schedule->movie_id ?? null)))
                                                <button type="button" @click="showReviewModal = true; selectedMovieId = '{{ $movieId }}'; selectedMovieTitle = '{{ addslashes($transaction->tickets->first()->schedule->movie->title ?? '') }}'; selectedMoviePoster = '{{ $transaction->tickets->first()->schedule->movie->poster_url ?? '' }}'; rating = 0; comment = ''" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors cursor-pointer">
                                                    Beri Rating
                                                </button>
                                            @else
                                                <span class="text-xs text-gray-400 font-medium">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- AlpineJS Review Modal --}}
        <div x-show="showReviewModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-transition.opacity
             style="display: none;">
            
            <div class="bg-[#CDE0EB] rounded-[20px] max-w-lg w-full p-8 shadow-2xl relative border-none" 
                 @click.away="showReviewModal = false"
                 x-transition.scale>
                
                {{-- Close Button --}}
                <button type="button" @click="showReviewModal = false" class="absolute top-4 right-4 text-[#4A3B32] opacity-70 hover:opacity-100 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                {{-- Form --}}
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="movie_id" :value="selectedMovieId">
                    <input type="hidden" name="rating" :value="rating">

                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-[#8BA7B8]/30">
                        <div class="w-16 h-20 bg-[#C4CCD3] rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                            <template x-if="selectedMoviePoster">
                                <img :src="selectedMoviePoster" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedMoviePoster">
                                <div class="w-full h-full flex items-center justify-center bg-[#C4CCD3]">
                                    <svg class="w-8 h-8 text-white opacity-60" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h2v2H4zm0 5h2v2H4zm0 5h2v2H4zm16-10h-2v2h2zm0 5h-2v2h2zm0 5h-2v2h2zM8 4h8v16H8z"/></svg>
                                </div>
                            </template>
                        </div>
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-widest text-[#4A3B32] opacity-70 mb-1">Menulis ulasan untuk</p>
                            <h2 class="text-xl font-extrabold text-[#4A3B32]" x-text="selectedMovieTitle"></h2>
                        </div>
                    </div>

                    {{-- Stars --}}
                    <div class="mb-6">
                        <label class="block text-[11px] font-extrabold uppercase tracking-widest mb-2 text-[#4A3B32]">Berikan Rating</label>
                        <div class="flex gap-2">
                            <template x-for="i in 5">
                                <button type="button" 
                                        class="hover:scale-110 transition-all duration-200 focus:outline-none" 
                                        :class="i <= rating ? 'text-[#F59E0B]' : 'text-[#C4CCD3]'"
                                        @click="rating = i">
                                    <svg class="w-10 h-10 fill-current drop-shadow-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Comments --}}
                    <div class="mb-6">
                        <label for="comment" class="block text-[11px] font-extrabold uppercase tracking-widest mb-2 text-[#4A3B32]">Komentar (Opsional)</label>
                        <textarea name="comment" 
                                  x-model="comment" 
                                  rows="4" 
                                  placeholder="Bagaimana menurutmu filmnya?" 
                                  class="w-full bg-[#FAF5E6] border-none rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-[#4A3B32] outline-none text-[#4A3B32] font-medium placeholder:font-normal placeholder:opacity-50 resize-none"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-[#8BA7B8]/30">
                        <button type="button" 
                                @click="showReviewModal = false" 
                                class="bg-[#FAF5E6] text-[#4A3B32] border border-[#4A3B32]/30 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                :disabled="rating === 0"
                                class="bg-[#4A3B32] text-white px-8 py-3.5 rounded-xl text-sm font-bold hover:bg-[#362a23] transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
