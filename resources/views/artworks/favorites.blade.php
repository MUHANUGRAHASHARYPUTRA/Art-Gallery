<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Favorites</h1>
                <p class="text-gray-500 mt-1">Collection of artworks you love.</p>
            </div>

            @if($favorites->isEmpty())
                <div class="bg-white rounded-3xl p-10 text-center shadow-sm">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No favorites yet</h3>
                    <p class="text-gray-500 mt-2 mb-6">Explore the gallery and save artworks that inspire you.</p>
                    <a href="{{ route('home') }}" class="text-indigo-600 font-bold hover:underline">Explore Gallery &rarr;</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($favorites as $artwork)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                            <a href="{{ route('artworks.show', $artwork) }}" class="block relative h-64 overflow-hidden bg-gray-100">
                                <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover object-center hover:scale-105 transition duration-500">
                            </a>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 truncate">{{ $artwork->title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">by {{ $artwork->user->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>