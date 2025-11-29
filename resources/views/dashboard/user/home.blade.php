<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">Creator Studio</h1>
                    <p class="text-gray-500 mt-2">Welcome back, {{ Auth::user()->name }}. Here is your performance overview.</p>
                </div>
                <a href="{{ route('artworks.create') }}" class="bg-black text-white px-6 py-3 rounded-full font-bold hover:bg-gray-800 transition flex items-center gap-2 shadow-lg shadow-gray-300/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Upload New Art
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Portfolio</span>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-1">{{ $stats['artworks_count'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Total Artworks</div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Engagement</span>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-1">{{ $stats['total_likes'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Total Likes</div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Community</span>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-1">{{ $stats['total_comments'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Comments Received</div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Reach</span>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-1">{{ $stats['total_favorites'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">Saved by Others</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Recent Uploads</h3>
                        <a href="{{ route('artworks.manage') }}" class="text-sm font-bold text-indigo-600 hover:underline">View All</a>
                    </div>

                    @if($recentArtworks->isEmpty())
                        <p class="text-gray-400">No artworks uploaded yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($recentArtworks as $artwork)
                                <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                    <img src="{{ Storage::url($artwork->image_path) }}" class="w-16 h-16 rounded-xl object-cover">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900">{{ $artwork->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $artwork->category->name }} • {{ $artwork->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-gray-500">
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg> {{ $artwork->likes->count() }}</span>
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{ $artwork->comments->count() }}</span>
                                    </div>
                                    <a href="{{ route('artworks.edit', $artwork) }}" class="text-gray-400 hover:text-indigo-600 font-bold text-sm">Edit</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-indigo-900 text-white rounded-3xl p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-48 h-48 bg-indigo-500 rounded-full opacity-20 blur-3xl"></div>
                    
                    <h3 class="text-xl font-bold mb-2 relative z-10">Your Profile</h3>
                    <p class="text-indigo-200 text-sm mb-6 relative z-10">Complete your profile to get noticed.</p>
                    
                    <div class="flex items-center gap-4 mb-8 relative z-10">
                        <div class="w-16 h-16 rounded-full bg-white text-indigo-900 flex items-center justify-center text-2xl font-black">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-lg">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-indigo-300">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="block w-full py-3 bg-white text-indigo-900 font-bold text-center rounded-xl hover:bg-indigo-50 transition relative z-10">
                        Edit Profile
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>