<x-app-layout>
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center gap-8">
                
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 rounded-full bg-indigo-600 flex items-center justify-center text-4xl text-white font-bold shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>

                <div class="text-center md:text-left flex-1">
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ $user->name }}</h1>
                    
                    @if($user->external_link)
                        <a href="{{ $user->external_link }}" target="_blank" class="text-indigo-600 font-bold hover:underline text-sm flex items-center justify-center md:justify-start gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            {{ parse_url($user->external_link, PHP_URL_HOST) }}
                        </a>
                    @else
                        <p class="text-gray-500 font-medium">{{ $user->email }}</p>
                    @endif
                    
                    <div class="flex items-center justify-center md:justify-start gap-2 mt-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $user->role === 'curator' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->role }}
                        </span>
                        <span class="text-sm text-gray-400">• Joined {{ $user->created_at->format('M Y') }}</span>
                    </div>

                    @auth
                        @if(Auth::id() !== $user->id)
                            <div class="mt-4">
                                <form action="{{ route('profile.follow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-6 py-2 rounded-full font-bold text-sm transition shadow-sm
                                        {{ $user->isFollowedBy(Auth::user()) 
                                            ? 'bg-gray-100 text-gray-800 border border-gray-300 hover:bg-gray-200' 
                                            : 'bg-black text-white hover:bg-gray-800' }}">
                                        {{ $user->isFollowedBy(Auth::user()) ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <div class="flex items-center justify-center md:justify-start gap-6 mt-4 text-sm text-gray-600">
                        <div><span class="font-bold text-gray-900">{{ $user->followers()->count() }}</span> Followers</div>
                        <div><span class="font-bold text-gray-900">{{ $user->followings()->count() }}</span> Following</div>
                    </div>

                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto md:mx-0">
                        {{ $user->bio ?? 'No bio yet.' }}
                    </p>
                </div>

                <div class="flex gap-8 text-center bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <div>
                        <div class="text-2xl font-black text-gray-900">{{ $artworks->count() }}</div>
                        <div class="text-xs text-gray-500 font-bold uppercase tracking-wider">Artworks</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-gray-900">{{ $totalLikes }}</div>
                        <div class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Likes</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Portfolio</h2>

            @if($artworks->isEmpty())
                <div class="bg-white rounded-3xl p-10 text-center shadow-sm">
                    <p class="text-gray-400">This user hasn't uploaded any artworks yet.</p>
                </div>
            @else
                <div class="columns-1 sm:columns-2 md:columns-3 xl:columns-4 gap-6 space-y-6">
                    @foreach($artworks as $artwork)
                        <div class="break-inside-avoid relative group mb-6">
                            <a href="{{ route('artworks.show', $artwork) }}" class="block rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-md transition duration-300">
                                <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-auto object-cover">
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 text-sm truncate">{{ $artwork->title }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">{{ $artwork->category->name ?? 'Art' }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>