<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('collections.index') }}" class="p-2 rounded-full bg-white text-gray-500 hover:text-black shadow-sm border border-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-3xl font-black text-gray-900">{{ $collection->name }}</h1>
                    <p class="text-gray-500">{{ $collection->artworks->count() }} Items</p>
                </div>
                
                <form action="{{ route('collections.destroy', $collection) }}" method="POST" onsubmit="return confirm('Delete this collection?');">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 font-bold text-sm">Delete Board</button>
                </form>
            </div>

            @if($artworks->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-400">This collection is empty.</p>
                </div>
            @else
                <div class="columns-1 sm:columns-2 md:columns-3 gap-6 space-y-6">
                    @foreach($artworks as $artwork)
                        <div class="break-inside-avoid relative group">
                            <a href="{{ route('artworks.show', $artwork) }}" class="block rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-md transition">
                                <img src="{{ Storage::url($artwork->image_path) }}" class="w-full h-auto object-cover">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>