<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Moodboards</h1>
                    <p class="text-gray-500 mt-1">Organize your inspiration.</p>
                </div>
                
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-collection')" class="px-6 py-3 bg-black text-white font-bold rounded-full hover:bg-gray-800 transition">
                    + New Board
                </button>
            </div>

            @if($collections->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No collections yet</h3>
                    <p class="text-gray-500 mt-2">Create a moodboard to start organizing artworks.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($collections as $collection)
                        <a href="{{ route('collections.show', $collection) }}" class="group block bg-white rounded-3xl p-4 shadow-sm hover:shadow-md transition border border-gray-100">
                            <div class="grid grid-cols-2 gap-1 rounded-2xl overflow-hidden h-40 mb-4 bg-gray-100">
                                @foreach($collection->artworks->take(4) as $art)
                                    <img src="{{ Storage::url($art->image_path) }}" class="w-full h-full object-cover">
                                @endforeach
                            </div>
                            <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $collection->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $collection->artworks_count }} Items</p>
                        </a>
                    @endforeach
                </div>
            @endif

            <x-modal name="create-collection" focusable>
                <form method="post" action="{{ route('collections.store') }}" class="p-6">
                    @csrf
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Create New Moodboard</h2>
                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="e.g. Logo Inspiration" required />
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="ms-3">Create</x-primary-button>
                    </div>
                </form>
            </x-modal>

        </div>
    </div>
</x-app-layout>