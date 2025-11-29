<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Artworks</h1>
                    <p class="text-gray-500 mt-1">Manage your portfolio content.</p>
                </div>
                <a href="{{ route('artworks.create') }}" class="px-6 py-3 bg-black text-white font-bold rounded-full hover:bg-gray-800 transition">
                    + Upload New
                </a>
            </div>

            @if($artworks->isEmpty())
                <div class="bg-white rounded-3xl p-10 text-center shadow-sm">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No artworks yet</h3>
                    <p class="text-gray-500 mt-2 mb-6">Start building your gallery by uploading your first masterpiece.</p>
                    <a href="{{ route('artworks.create') }}" class="text-indigo-600 font-bold hover:underline">Upload Now &rarr;</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($artworks as $artwork)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-sm group hover:shadow-md transition duration-300">
                            <div class="relative h-64 overflow-hidden bg-gray-100">
                                <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-800">
                                    {{ $artwork->category->name }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">{{ $artwork->title }}</h3>
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $artwork->description }}</p>
                                
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('artworks.edit', $artwork) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this artwork?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <a href="{{ route('artworks.show', $artwork) }}" class="text-sm font-bold text-gray-900 hover:underline">View Live &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>