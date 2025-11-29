<x-app-layout>
    <div class="relative h-[500px] bg-gray-900 overflow-hidden">
        @if ($challenge->banner_path)
            <img src="{{ Storage::url($challenge->banner_path) }}"
                class="absolute inset-0 w-full h-full object-cover opacity-60" data-aos="zoom-out"
                data-aos-duration="1500">
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 to-black opacity-80"></div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>

        <div class="absolute bottom-0 left-0 right-0 p-8 lg:p-16 max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6" data-aos="fade-up">
                <div class="max-w-3xl">
                    <div class="flex items-center gap-3 mb-4">
                        @if ($challenge->isActive())
                            <span
                                class="px-4 py-1.5 bg-green-500 text-white text-xs font-bold uppercase tracking-widest rounded-full shadow-lg shadow-green-500/30 animate-pulse">
                                Active Challenge
                            </span>
                        @else
                            <span
                                class="px-4 py-1.5 bg-gray-700 text-white text-xs font-bold uppercase tracking-widest rounded-full">
                                Ended
                            </span>
                        @endif
                        <span class="text-gray-300 text-sm font-medium">Hosted by <span
                                class="text-white">{{ $challenge->curator->name }}</span></span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-tight mb-6">
                        {{ $challenge->title }}
                    </h1>
                    <p class="text-lg text-gray-300 leading-relaxed max-w-2xl">
                        {{ $challenge->description }}
                    </p>
                </div>

                <div
                    class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl text-center min-w-[200px]">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Deadline</p>
                    <p class="text-3xl font-black text-white">{{ $challenge->end_date->format('d M') }}</p>
                    <p class="text-sm text-gray-300">{{ $challenge->end_date->format('Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                <div class="space-y-8">
                    <div class="bg-gray-50 p-8 rounded-[2rem] border border-gray-100" data-aos="fade-right">
                        <h3 class="font-black text-gray-900 text-xl mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Rules & Guidelines
                        </h3>
                        <div class="prose prose-sm text-gray-600 leading-relaxed">
                            {!! nl2br(e($challenge->rules)) !!}
                        </div>
                    </div>

                    @auth
                        @if (Auth::user()->role === 'member')
                            <div class="bg-indigo-900 text-white p-8 rounded-[2rem] relative overflow-hidden shadow-xl"
                                data-aos="fade-up" data-aos-delay="200">
                                <div
                                    class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 bg-indigo-500 rounded-full opacity-30 blur-3xl">
                                </div>

                                @if ($challenge->isActive())
                                    <h3 class="font-black text-2xl mb-4 relative z-10">Join the Challenge</h3>

                                    @if ($myArtworks->isEmpty())
                                        <p class="text-indigo-200 mb-6 relative z-10">You need to upload an artwork to your
                                            portfolio first.</p>
                                        <a href="{{ route('artworks.create') }}"
                                            class="block w-full py-4 bg-white text-indigo-900 font-bold text-center rounded-xl hover:bg-indigo-50 transition relative z-10">
                                            Upload to Portfolio
                                        </a>
                                    @else
                                        <p class="text-indigo-200 mb-6 relative z-10">Select one of your existing artworks
                                            to submit.</p>
                                        <form action="{{ route('challenges.submit', $challenge) }}" method="POST"
                                            class="relative z-10 space-y-4">
                                            @csrf
                                            <div class="relative">
                                                <select name="artwork_id"
                                                    class="w-full px-5 py-3 pr-10 rounded-xl bg-white/10 border border-white/20 text-white focus:bg-white/20 focus:ring-0 focus:border-white transition appearance-none">
                                                    @foreach ($myArtworks as $art)
                                                        <option value="{{ $art->id }}" class="text-gray-900">
                                                            {{ $art->title }}</option>
                                                    @endforeach
                                                </select>
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-white">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="w-full py-4 bg-white text-indigo-900 font-bold rounded-xl hover:bg-indigo-50 transition shadow-lg">
                                                Submit Entry
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <h3 class="font-black text-2xl mb-2">Challenge Ended</h3>
                                    <p class="text-indigo-300">Submissions are closed for this event.</p>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-900 text-white p-8 rounded-[2rem] text-center" data-aos="fade-up">
                            <h3 class="font-bold text-xl mb-2">Want to participate?</h3>
                            <p class="text-gray-400 mb-6 text-sm">Log in or create an account to submit your work.</p>
                            <a href="{{ route('login') }}"
                                class="inline-block px-8 py-3 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition">Log
                                In</a>
                        </div>
                    @endauth
                </div>

                <div class="lg:col-span-2">

                    @php
                        $winners = $submissions->whereNotNull('winner_rank')->sortBy('winner_rank');
                    @endphp

                    @if ($winners->isNotEmpty())
                        <div class="mb-12" data-aos="fade-down">
                            <h2 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-3">
                                <span class="text-4xl">🏆</span> Hall of Fame
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                                @foreach ($winners as $winner)
                                    <div
                                        class="relative group {{ $winner->winner_rank == 1 ? 'md:-mt-12 order-first md:order-2' : 'order-last md:order-1' }}">
                                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                            @if ($winner->winner_rank == 1)
                                                <div
                                                    class="w-12 h-12 bg-yellow-400 text-yellow-900 rounded-full flex items-center justify-center font-black text-xl shadow-lg border-4 border-white">
                                                    1</div>
                                            @elseif($winner->winner_rank == 2)
                                                <div
                                                    class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold text-lg shadow-lg border-4 border-white">
                                                    2</div>
                                            @else
                                                <div
                                                    class="w-10 h-10 bg-orange-300 text-orange-900 rounded-full flex items-center justify-center font-bold text-lg shadow-lg border-4 border-white">
                                                    3</div>
                                            @endif
                                        </div>

                                        <a href="{{ route('artworks.show', $winner->artwork) }}"
                                            class="block rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 bg-white">
                                            <div class="h-64 overflow-hidden">
                                                <img src="{{ Storage::url($winner->artwork->image_path) }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="p-6 text-center">
                                                <h3 class="font-bold text-gray-900 truncate">
                                                    {{ $winner->artwork->title }}</h3>
                                                <p class="text-xs text-gray-500 mt-1">by
                                                    {{ $winner->artwork->user->name }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">All Submissions <span
                                class="text-gray-400 text-lg ml-2">{{ $submissions->count() }}</span></h2>
                    </div>

                    @if ($submissions->isEmpty())
                        <div class="py-20 text-center border-2 border-dashed border-gray-200 rounded-[3rem]">
                            <p class="text-gray-400 text-lg">No submissions yet. Be the first!</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach ($submissions as $submission)
                                <div class="relative group" data-aos="fade-up">
                                    <div
                                        class="rounded-2xl overflow-hidden bg-gray-100 relative shadow-sm hover:shadow-xl transition duration-500">
                                        <img src="{{ Storage::url($submission->artwork->image_path) }}"
                                            class="w-full h-64 object-cover transition duration-700 group-hover:scale-105">

                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6">
                                            <h4 class="text-white font-bold text-lg mb-1">
                                                {{ $submission->artwork->title }}</h4>
                                            <p class="text-gray-300 text-xs font-medium">by
                                                {{ $submission->artwork->user->name }}</p>
                                            <a href="{{ route('artworks.show', $submission->artwork) }}"
                                                class="absolute inset-0 z-10"></a>
                                        </div>

                                        @if ($submission->winner_rank)
                                            <div
                                                class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold shadow-sm z-20">
                                                @if ($submission->winner_rank == 1)
                                                    🥇 1st
                                                @elseif($submission->winner_rank == 2)
                                                    🥈 2nd
                                                @else
                                                    🥉 3rd
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    @auth
                                        @if (Auth::id() === $challenge->user_id)
                                            <div
                                                class="mt-3 bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between gap-2">
                                                <span class="text-xs font-bold text-gray-400 uppercase">Award:</span>
                                                <div class="flex gap-1 flex-1">
                                                    <form
                                                        action="{{ route('curator.challenges.winner', [$challenge, $submission]) }}"
                                                        method="POST" class="flex-1">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="rank" value="1">
                                                        <button
                                                            class="w-full py-1.5 {{ $submission->winner_rank == 1 ? 'bg-yellow-400 text-black' : 'bg-gray-100 text-gray-500 hover:bg-yellow-100' }} rounded-lg text-xs font-bold transition"
                                                            title="1st Place">1</button>
                                                    </form>
                                                    <form
                                                        action="{{ route('curator.challenges.winner', [$challenge, $submission]) }}"
                                                        method="POST" class="flex-1">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="rank" value="2">
                                                        <button
                                                            class="w-full py-1.5 {{ $submission->winner_rank == 2 ? 'bg-gray-300 text-black' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }} rounded-lg text-xs font-bold transition"
                                                            title="2nd Place">2</button>
                                                    </form>
                                                    <form
                                                        action="{{ route('curator.challenges.winner', [$challenge, $submission]) }}"
                                                        method="POST" class="flex-1">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="rank" value="3">
                                                        <button
                                                            class="w-full py-1.5 {{ $submission->winner_rank == 3 ? 'bg-orange-300 text-black' : 'bg-gray-100 text-gray-500 hover:bg-orange-100' }} rounded-lg text-xs font-bold transition"
                                                            title="3rd Place">3</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
