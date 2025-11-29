<x-app-layout>
    <div class="relative h-[400px] bg-gray-900">
        @if($challenge->banner_path)
            <img src="{{ Storage::url($challenge->banner_path) }}" class="w-full h-full object-cover opacity-60">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 lg:p-12 max-w-7xl mx-auto">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-white/20 backdrop-blur text-white text-xs font-bold rounded-full uppercase tracking-wider">
                    {{ $challenge->isActive() ? 'Active Challenge' : 'Challenge Ended' }}
                </span>
                <span class="text-gray-300 text-sm font-medium">Hosted by {{ $challenge->curator->name }}</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">{{ $challenge->title }}</h1>
            <p class="text-gray-300 max-w-2xl text-lg leading-relaxed">{{ $challenge->description }}</p>
        </div>
    </div>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="space-y-8">
                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <h3 class="font-bold text-gray-900 text-lg mb-4">Timeline</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Start Date</span>
                                <span class="font-bold">{{ $challenge->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Deadline</span>
                                <span class="font-bold">{{ $challenge->end_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <h3 class="font-bold text-gray-900 text-lg mb-4">Rules</h3>
                        <div class="prose prose-sm text-gray-600">
                            {!! nl2br(e($challenge->rules)) !!}
                        </div>
                    </div>

                    @if(Auth::check() && Auth::user()->role === 'member' && $challenge->isActive())
                        <div class="bg-indigo-50 p-6 rounded-3xl border border-indigo-100">
                            <h3 class="font-bold text-indigo-900 text-lg mb-4">Submit Your Work</h3>
                            
                            @if($myArtworks->isEmpty())
                                <p class="text-sm text-indigo-700 mb-4">You don't have any eligible artworks to submit. Upload one first!</p>
                                <a href="{{ route('artworks.create') }}" class="block w-full py-3 bg-indigo-600 text-white font-bold text-center rounded-xl hover:bg-indigo-700 transition">Upload Artwork</a>
                            @else
                                <form action="{{ route('challenges.submit', $challenge) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-xs font-bold text-indigo-800 uppercase tracking-wider mb-2">Select from your gallery</label>
                                        <select name="artwork_id" class="w-full px-4 py-2 rounded-xl bg-white border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                                            @foreach($myArtworks as $art)
                                                <option value="{{ $art->id }}">{{ $art->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                        Submit Entry
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Submissions ({{ $submissions->count() }})</h2>
                    </div>

                    @if($submissions->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                            <p class="text-gray-400 font-medium">No submissions yet.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($submissions as $submission)
                                <div class="relative group">
                                    <div class="rounded-2xl overflow-hidden bg-gray-100 relative">
                                        <img src="{{ Storage::url($submission->artwork->image_path) }}" class="w-full h-64 object-cover">
                                        
                                        @if($submission->winner_rank)
                                            <div class="absolute top-4 right-4 z-10">
                                                @if($submission->winner_rank == 1)
                                                    <span class="px-3 py-1 bg-yellow-400 text-black font-bold rounded-full text-xs shadow-lg">🥇 1st Place</span>
                                                @elseif($submission->winner_rank == 2)
                                                    <span class="px-3 py-1 bg-gray-300 text-black font-bold rounded-full text-xs shadow-lg">🥈 2nd Place</span>
                                                @else
                                                    <span class="px-3 py-1 bg-orange-300 text-black font-bold rounded-full text-xs shadow-lg">🥉 3rd Place</span>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6">
                                            <h4 class="text-white font-bold">{{ $submission->artwork->title }}</h4>
                                            <p class="text-gray-300 text-sm">by {{ $submission->artwork->user->name }}</p>
                                            <a href="{{ route('artworks.show', $submission->artwork) }}" class="mt-3 text-xs font-bold text-white underline">View Details</a>
                                        </div>
                                    </div>

                                    @if(Auth::id() === $challenge->user_id && !$challenge->isActive())
                                        <div class="mt-3 flex gap-2">
                                            <form action="{{ route('curator.challenges.winner', [$challenge, $submission]) }}" method="POST" class="flex-1">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="rank" value="1">
                                                <button class="w-full py-1 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 text-xs font-bold rounded">🥇 1st</button>
                                            </form>
                                            <form action="{{ route('curator.challenges.winner', [$challenge, $submission]) }}" method="POST" class="flex-1">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="rank" value="2">
                                                <button class="w-full py-1 bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-bold rounded">🥈 2nd</button>
                                            </form>
                                            <form action="{{ route('curator.challenges.winner', [$challenge, $submission]) }}" method="POST" class="flex-1">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="rank" value="3">
                                                <button class="w-full py-1 bg-orange-100 text-orange-800 hover:bg-orange-200 text-xs font-bold rounded">🥉 3rd</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>